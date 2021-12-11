<?php

namespace App\Http\Livewire\Forms\Products;

use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\AttributeTranslation;
use App\Models\AttributeValue;
use App\Facades\TenantSettings;
use App\Models\AttributeValueTranslation;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductTranslation;
use App\Models\Upload;
use App\Rules\AttributeValuesSelected;
use App\Rules\EVModelsExist;
use DB;
use EVS;
use Categories;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use Str;

class CheckoutForm extends Component
{
    public $form;

    protected $listeners = [

    ];

    protected function rules()
    {
        return [
            'form.first_name' => [],
            'form.last_name' => [],
            'form.email' => [],
            'form.address' => [],
            'form.address_2' => [],
            'form.country' => [],
            'form.state' => [],
            'form.zip' => [],
            'form.same_billing_and_shipping_address' => [],
            'form.save_info' => [],
        ];
    }

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {

    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initCheckoutForm');
    }

    public function render()
    {
        return view('livewire.forms.products.product-form');
    }

    public function refreshVariationsDatatable() {
        // TODO: Refresh variations datatable
        $this->emit('refreshDatatable');
        //$this->emit('updatedAttributeValues', $this->variations_attributes);
    }

    public function validateSpecificSet($set_name, $next_page, $is_last = false, $insert_on_step = null)
    {
        if($set_name) {
            foreach($this->rulesSets as $key => $set) {
                $this->page = $key; // set page
                $this->validate($set); // validate page

                if($set_name == $key) {
                    break;
                }
            }

            // Check if insert on specific step is set
            if(is_array($insert_on_step) && (in_array($next_page, $insert_on_step) || in_array($set_name, $insert_on_step))) {
                if(empty($this->product->id)) {
                    $this->insert(true);
                } else {
                    $this->update();
                }
            } else if($is_last) {
                if(empty($this->product->id)) {
                    $this->insert();
                } else {
                    $this->update();
                }
            }

            $this->page = $next_page;
        }
    }

    /**
     * Inserts product data to database.
     * Inserts can be partial or full.
     * 1. Full: inserts all the product data, attributes, variations, translations, stocks etc. to the database
     * 2. Partial: inserts only part of the data to the database and creates a draft version of the product (before adding attributes, variations, stocks)
     *
     * @param false $partial
     */
    protected function insert(bool $partial = false): void
    {
        DB::beginTransaction();
        $this->insert_success = false;

        try {
            // SET: Product Data
            $this->setProductData($partial ? 0 : 1);

            // SET: Product Categories
            $this->setProductCategories();

            // SET: Product Translations
            $this->setProductTranslation();

            // SET: Main Product Stocks
            $this->setProductStocks();

            // TODO: VAT & TAX, Flash Deals

            if(!$partial) {
                // SET: Attribute relationships
                $this->setAttributes();
            }

            DB::commit();

            $this->insert_success = true;

            //$this->emit('setProduct', $this->product);
            $this->dispatchBrowserEvent('goToTop');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    protected function update() {
        $this->update_success = false;

        DB::beginTransaction();

        try {
            // SET: Product Data
            $this->setProductData();

            // SET: Product Categories
            $this->setProductCategories();

            // SET: Product Translations
            $this->setProductTranslation();

            // SET: Main & Variations Product Stocks
            $this->setProductStocks();

            // TODO: VAT & TAX, Flash Deals

            // SET: Attribute relationships
            $this->setAttributes();

            DB::commit();

            $this->update_success = true;

            $this->dispatchBrowserEvent('toastIt', ['id' => '#product-updated-toast']);
            $this->dispatchBrowserEvent('goToTop');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    protected function setProductData($published = 1) {
        if(empty($this->product->brand_id)) {
            $this->product->brand_id = null;
        }

        if($this->action === 'insert') {
            if (auth()->user()->isSeller()) {
                $this->product->user_id = auth()->user()->id;
                $this->product->added_by = 'seller';
            } else {
                $this->product->user_id = \App\Models\User::where('user_type', 'admin')->first()->id;
                $this->product->added_by = 'admin';
            }
        }

        $this->product->tags = implode(',', $this->product->tags);

        if ($this->product->shipping_type === 'free') {
            $this->product->shipping_cost = 0;
        } elseif ($this->product->shipping_type === 'product_wise') {
            $this->product->shipping_cost = json_encode([]);
        }

        // Purify WYSIWYG before saving
        $this->product->description = Purifier::clean($this->product->description);

        if(empty($this->product->excerpt)) {
            $this->product->excerpt = strip_tags(Str::limit($this->product->description, 320, '...'));
        } else {
            $this->product->excerpt = strip_tags(Str::limit($this->product->excerpt, 320, '...'));
        }

        // SEO
        if (empty($this->product->meta_title)) {
            $this->product->meta_img = $this->product->name;
        }

        if (empty($this->product->meta_description)) {
            $this->product->meta_description = trim(strip_tags($this->product->description ?? ''));
        }

        // TODO: Add Featured, Cash on delivery, Today's deal to the form
        $this->product->cash_on_delivery = 0;
        $this->product->featured = 0;
        $this->product->todays_deal = 0;

        // TODO: Add Product status option to the form - published, draft
        $this->product->published = 1;

        // TODO: Remove following columns from the products table: variant_product, choice_options, colors, variations, current_stock, min_qty, low_stock_quantity
        // TODO: Move current_stock, min_qty and low_stock_quantity to Product Stocks table!

        // Save product
        $this->product->save();

        // DONE: Sync thumbnail, gallery, meta_img and other dynamic uploads
        $this->product->syncUploads();
    }

    protected function setProductCategories() {
        if(!empty($this->selected_categories)) {
            $categories_idx = collect([]);

            foreach($this->selected_categories as $selected) {
                // $selected is a slug_path of the category
                $cat = Categories::getBySlugPath($selected);

                if($cat) {
                    $categories_idx->push($cat['id']);
                }
            }

            $this->product->categories()->sync($categories_idx->toArray());
        }
    }

    protected function setProductTranslation() {
        $product_translation = ProductTranslation::firstOrNew(['lang' => config('app.locale'), 'product_id' => $this->product->id]);
        $product_translation->name = $this->product->name;
        $product_translation->unit = $this->product->unit;
        $product_translation->description = $this->product->description;
        // $product_translation->excerpt = $this->product->excerpt;
        // $product_translation->meta_title = $this->product->meta_title;
        // $product_translation->meta_description = $this->product->meta_description;
        $product_translation->save();
    }

    protected function setProductStocks() {
        $product_stock = ProductStock::firstOrNew(['subject_id' => $this->product->id, 'subject_type' => Product::class]);
        $product_stock->sku = $this->product->temp_sku;
        $product_stock->qty = $this->product->current_stock;
        $product_stock->low_stock_qty = $this->product->low_stock_qty;
        $product_stock->save();
    }

    /**
     * @throws \Exception
     */
    protected function setAttributes() {
        $selected_attributes = collect($this->attributes)->filter(function($att, $key) {
            $att = (object) $att;
            return $att->selected === true;
        });

        if($selected_attributes) {
            foreach($selected_attributes as $att) {
                $att = (object) $att;
                $att_values = $att->attribute_values;

                if($att_values) {
                    // Is-predefined attributes are dropdown/radio/checkbox and they have predefined values
                    // while other types have only one item in values array - with an ID (existing value) or without ID (not yet added value, just default template)
                    if(!$att->is_predefined) {
                        // Create the value first
                        $att_val = (!empty($att_values[0]['id'])) ? AttributeValue::find($att_values[0]['id']) : new AttributeValue();
                        $att_val->attribute_id = (!empty($att_values[0]['id'])) ? $att_val->attribute_id : $att->id;
                        $att_val->values = $att_values[0]['values'] ?? null;
                        $att_val->save();

                        if(empty($att_values[0]['id'])) {
                            $att_values[0]['id'] = $att_val->id;

                            // Set attribute value translations for non-predefined attributes
                            $attribute_value_translation = AttributeValueTranslation::firstOrNew(['lang' => config('app.locale'), 'attribute_value_id' => $att_val->id]);
                            $attribute_value_translation->name = $att_val->values;
                            $attribute_value_translation->save();
                        }
                    }

                    foreach($att_values as $att_value) {
                        $att_value = (object) $att_value;

                        if($att_value->id ?? null) {
                            if($att_value->selected ?? null) {
                                // Create or find product-attribute relationship, but don't yet persist anything to DB
                                $att_rel = AttributeRelationship::firstOrNew([
                                    'subject_type' => Product::class,
                                    'subject_id' => $this->product->id,
                                    'attribute_id' => $att->id,
                                    'attribute_value_id' => $att_value->id
                                ]);
                                $att_rel->for_variations = $att->type === 'dropdown' ? $att->for_variations : false;
                                $att_rel->save();
                            } else {
                                // Remove attribute relationship if "selected" is false/null
                                AttributeRelationship::where([
                                    'subject_type' => Product::class,
                                    'subject_id' => $this->product->id,
                                    'attribute_id' => $att->id,
                                    'attribute_value_id' => $att_value->id
                                ])->delete();
                            }
                        }
                    }
                }
            }
        }
    }

    public function updateAttributeValuesForVariations() {
        $atts = collect($this->attributes)->filter(function($att, $key) {
            $att = (object) $att;
            return $att->selected === true && $att->for_variations === true;
        });

        if($atts) {
            foreach ($atts as $att) {
                $att = (object)$att;
                $att_values = $att->attribute_values;

                if ($att_values) {
                    // ????
                    // TODO: What happens when attribute values (used for variations) are changed AND product is saved without touching the variations modal?
                    // FIX: It should SOFT DELETE product variations related to attribute value! IMPORTANT thing is to use SOFT DELETES, because if vendor wants to
                    // revive the attribute value for some reason and generate variations related to it, we need to bring back the old variations in the DB from the dead.
                    // This way we can always generate proper sales reports and never miss data!
                    // SOFT DELETES FOR PRODUCT VARIATIONS ARE VERY IMPORTANT!!!!
                    // NOTE: There can always be ONE product variation combination for certain product in the DB! We should never remove it fully, cuz we'll lose the data associated with it (number of variation sales, etc.)
                }
            }
        }
    }

    public function getVariationsAttributesProperty() {
        $atts_for_variations = collect($this->attributes)->filter(function($att, $key) {
            return ((object) $att)->for_variations === true;
        });

        return $atts_for_variations;
    }

    public function levelSelectedCategories() {
        $data = [];

        if($this->selected_categories) {
            foreach($this->selected_categories as $selected) {
                $level = count(explode('.', $selected)) - 1;
                if(!isset($data[$level])) {
                    $data[$level] = [];
                }

                $data[$level][] = $selected;
            }
        }

        return $data;
    }
}
