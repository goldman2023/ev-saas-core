<?php

namespace App\Http\Livewire\Dashboard\Forms\Products;

use App\Enums\StockVisibilityStateEnum;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use App\Rules\UniqueSKU;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use WE;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;

class StockManagementForm extends Component
{
    use RulesSets;

    public $product;

    public $variations;

    public $attributes;

    public $serial_numbers;

    public $serial_status;

    public $serial_search;

    public $new_serial_numbers;

    public $edit_serial_numbers;

    protected $listeners = [
        'refreshForm' => '$refresh',
    ];

    /*
     * This function has to list rules for every property we are going to use on FE! Otherwise property is not accessible on FE side!!!
     * Use ->getRuleSet($set_name) to validate only specific set of rules.
     * If ->validate() without params is called, all rules will be used for variations.
     */
    protected function rules()
    {
        return [
            'product.sku' => ['required', 'filled', Rule::unique($this->product->stock->getTable(), 'sku')->ignore($this->product->stock->id ?? null)],
            'product.barcode' => ['nullable'],
            'product.current_stock' => 'required|numeric|min:0',
            'product.low_stock_qty' => 'required|numeric|min:0',
            'product.use_serial' => 'required|bool',
            'product.stock_visibility_state' => 'required|in:quantity,text,hide',
            'product.min_qty' => 'required|numeric|min:1',
            'product.unit' => 'required',
            'product.allow_out_of_stock_purchases' => 'required|boolean',

            'new_serial_numbers.*.serial_number' => 'required|unique:App\Models\SerialNumber,serial_number|distinct:ignore_case',
            'new_serial_numbers.*.status' => ['required', 'in:in_stock,out_of_stock,reserved'],
            'edit_serial_numbers.*.serial_number' => ['required'],
            'edit_serial_numbers.*.status' => ['required', 'in:'.SerialNumber::getStatusEnum(true)],
            'variations.*.name' => [],
            'variations.*.sku' => ['required', 'filled', new UniqueSKU($this->variations->mapWithKeys(function ($item, $key) {
                return ['variations.'.$key.'.sku' => $item];
            }))],
            'variations.*.low_stock_qty' => 'required|numeric|min:0',
            'variations.*.current_stock' => 'required|numeric|min:0',
        ];
    }

    protected function messages()
    {
        return [
            'product.sku.required' => translate('This field is required'),
            'product.sku.filled' => translate('This field cannot be empty'),
            'product.sku.unique' => translate('SKU must be unique. Another item is using it already.'),
            'product.current_stock.required' => translate('This field is required'),
            'product.current_stock.numeric' => translate('Quantity must be numeric'),
            'product.current_stock.min' => translate('Quantity cannot be less than 0'),
            'product.low_stock_qty.required' => translate('This field is required'),
            'product.low_stock_qty.numeric' => translate('Must be numeric'),
            'product.low_stock_qty.min' => translate('Cannot be less than 0'),
            'product.stock_visibility_state.required' => translate('This field is required'),
            'product.stock_visibility_state.in' => translate('Must be one of the following: quantity, text, hide'),

            'new_serial_numbers.*.serial_number.required' => translate('This field is required'),
            'new_serial_numbers.*.serial_number.unique' => translate('Serial number already taken'),
            'new_serial_numbers.*.serial_number.distinct' => translate('This field has a duplicate value'),
            'new_serial_numbers.*.status.required' => translate('This field is required'),
            'new_serial_numbers.*.status.in' => translate('Value must be one of these: '.SerialNumber::getStatusEnum(true, ', ')),

            'edit_serial_numbers.*.serial_number.required' => translate('This field is required'),
            'edit_serial_numbers.*.serial_number.unique' => translate('Serial number already taken'),
            'edit_serial_numbers.*.serial_number.distinct' => translate('This field has a duplicate value'),
            'edit_serial_numbers.*.status.required' => translate('This field is required'),
            'edit_serial_numbers.*.status.in' => translate('Value must be one of these: '.SerialNumber::getStatusEnum(true, ', ')),

            'variations.*.sku.required' => translate('This field is required'),
            'variations.*.sku.filled' => translate('This field cannot be empty'),
            'variations.*.current_stock.required' => translate('This field is required'),
            'variations.*.current_stock.numeric' => translate('Quantity must be numeric'),
            'variations.*.current_stock.min' => translate('Quantity cannot be less than 0'),
            'variations.*.low_stock_qty.required' => translate('This field is required'),
            'variations.*.low_stock_qty.numeric' => translate('Must be numeric'),
            'variations.*.low_stock_qty.min' => translate('Cannot be less than 0'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @param ?Product $product Passed Product model as a pointer
     * @return void
     */
    public function mount(Product &$product = null)
    {
        // Set default params
        if ($product) {
            $this->product = $product;
            $this->variations = $this->product->variations;
            $this->fetchSerialNumbers();
            $this->attributes = $this->product->variant_attributes();
            $this->status = '';
            $this->new_serial_numbers = [];
            $this->serial_search = null;
        }
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initStockManagementForm');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.products.product-stock-management-form');
    }

    protected function mapEditingSerialNumbers()
    {
        $mapped = $this->serial_numbers->map(function ($item) {
            $is_trashed = $item->trashed();
            $item = $item->toArray();

            $item['edit_mode'] = false;
            $item['trashed'] = $is_trashed;

            return $item;
        });

        $this->edit_serial_numbers = $mapped->toArray();
    }

    public function invalidateSerialNumber(SerialNumber $serial_number)
    {
        $serial_number->delete();

        // 1. Get serial_numbers (a list without deleted serial_number)
        $this->fetchSerialNumbers();
    }

    public function reviveSerialNumber($id)
    {
        // We cannot use Model injection based on provided $id because model we want to get here is Soft Deleted and that's why we'll get error 404 page,
        // If we check debug bar, we are getting: No query results for model [App\Models\SerialNumber] in vendor/livewire/livewire/src/ImplicitlyBoundMethod.php#98
        // Basically Implicit Model injection does not work with soft deleted models
        $serial_number = SerialNumber::withTrashed()->find($id);
        $serial_number->restore();

        $this->fetchSerialNumbers();
    }

    public function insertSerialNumbers()
    {
        $this->validate($this->getRuleSet('new_serial_numbers'));

        DB::beginTransaction();

        try {
            if (! empty($this->new_serial_numbers)) {
                foreach ($this->new_serial_numbers as $new_serial) {
                    $serial = SerialNumber::firstOrNew([
                        'subject_id' => $this->product->id,
                        'subject_type' => Product::class,
                        'serial_number' => $new_serial['serial_number'],
                    ]);
                    $serial->status = $new_serial['status'];
                    $serial->save();
                }
            }

            DB::commit();

            $this->fetchSerialNumbers();

            $this->new_serial_numbers = []; // reset new array
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function updateSerialNumber($id)
    {
        $serial_number = SerialNumber::withTrashed()->find($id); // Check why we don't use model injection in fun. parameters inside reviveSerialNumber() function

        $item_key = collect($this->edit_serial_numbers)->search(fn ($value, $key) => $serial_number->id === $value['id']);

        $this->validate($this->getRuleSet('edit_serial_numbers'));

        DB::beginTransaction();

        try {
            $updated_serial = collect($this->edit_serial_numbers)->get($item_key);

            if (! empty($updated_serial)) {
                $serial_number->serial_number = $updated_serial['serial_number'];
                $serial_number->status = $updated_serial['status'];
                $serial_number->save();

                DB::commit();

                $this->fetchSerialNumbers();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function updatedSerialStatus()
    {
        $this->fetchSerialNumbers();
    }

    public function updatedSerialSearch()
    {
        $this->fetchSerialNumbers();
    }

    protected function fetchSerialNumbers()
    {
        $query = $this->product->serial_numbers();

        // Filtering by `Serial status`
        if (in_array($this->serial_status, SerialNumber::getStatusEnum())) {
            $query->where('status', $this->serial_status);
        } elseif ($this->serial_status === 'trashed') {
            $query->onlyTrashed();
        }

        // Filtering by `Search key`
        if (! empty($trimmed_search = trim($this->serial_search))) {
            $query->where('serial_number', 'like', '%'.$trimmed_search.'%');
        }

        $this->serial_numbers = $query->get();

        $this->mapEditingSerialNumbers();
    }

    public function updateMainStock()
    {
        $this->validate($this->getRuleSet('product'));

        DB::beginTransaction();

        try {
            // TODO: Write main stock update logic
            $product_stock = ProductStock::firstOrNew(['subject_id' => $this->product->id, 'subject_type' => $this->product::class]);
            $product_stock->sku = $this->product->sku;
            $product_stock->qty = $this->product->current_stock;
            $product_stock->low_stock_qty = $this->product->low_stock_qty;
            $product_stock->use_serial = $this->product->use_serial;
            $product_stock->save();

            // Save stock visibility state (TODO: Think about moving stock-visibility-state column to `stocks` table instead of `products`)
            $this->product->save();

            DB::commit();

            $this->dispatchBrowserEvent('toast', ['id' => 'stock-updated-toast', 'content' => translate('Main product updated successfully!')]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function updateVariationsStocks()
    {
        $this->validate($this->getRuleSet('variations'));

        DB::beginTransaction();

        try {
            foreach ($this->variations as $variation) {
                $product_stock = ProductStock::firstOrNew(['subject_id' => $variation->id, 'subject_type' => $variation::class]);
                $product_stock->sku = $variation->sku;
                $product_stock->qty = $variation->current_stock;
                $product_stock->low_stock_qty = $variation->low_stock_qty;
                $product_stock->save();
            }
            DB::commit();

            $this->dispatchBrowserEvent('toast', ['id' => 'stock-updated-toast', 'content' => translate('Variations stocks updated successfully!')]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
