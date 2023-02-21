<?php

namespace App\Traits;

use FX;
use TaxService;
use App\Models\Plan;
use App\Models\FlashDeal;
use App\Builders\BaseBuilder;
use App\Enums\AmountPercentTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait PriceTrait
{
    protected $prices_loaded = false;

    public mixed $total_price;

    public mixed $discounted_price;

    public mixed $base_price;

    /************************************
     * Abstract Trait Methods *
     ************************************/
    abstract public function getPriceColumn();
//    abstract public function useVariations(): ?bool;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootPriceTrait()
    {
        static::addGlobalScope('withPricesAndTaxAndFlashDeals', function (mixed $builder) {
            // Eager Load Flash Deals
            $builder->with(['flash_deals']);
        });
        
        // When model relations data is retrieved, populate model prices data!
        static::relationsRetrieved(function ($model) {
            if (! $model->relationLoaded('flash_deals')) {
                $model->load('flash_deals');
            }

            if(!$model->prices_loaded) {
                $model->getTotalPrice();
                $model->getDiscountedPrice();
                $model->getBasePrice();
    
                if($model->isSubscribable()) {
                    $model->getBaseAnnualPrice();
                    $model->getTotalAnnualPrice();
                }

                $model->prices_loaded = true;
            }
            
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializePriceTrait(): void
    {
        $this->appendCoreProperties(['total_price', 'discounted_price', 'base_price', 'total_annual_price', 'base_annual_price']);
        $this->append(['total_price', 'discounted_price', 'base_price', 'total_annual_price', 'base_annual_price']);

        // These calculated prices ARE NOT FILLABLE! They are calculated based on other properties!
        // $this->fillable(array_unique(array_merge($this->fillable, ['total_price', 'discounted_price', 'base_price'])));
    }

    /**
     * Get base currency
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function baseCurrency(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return !empty($value) ? strtoupper($value) : strtoupper(FX::getDefaultCurrency()->code);
            },
        );
    }


    /**
     * Get discount type
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function discountType(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return !empty($value) && AmountPercentTypeEnum::in($value) ? $value : AmountPercentTypeEnum::amount()->value;
            },
        );
    }

    /************************************
     * Price Relation Functions *
     ************************************/
    public function flash_deals()
    {
        return $this->morphToMany(FlashDeal::class, 'subject', 'flash_deal_relationships', 'subject_id', 'flash_deal_id')
            ->where([
                ['status', '=', 1],
                ['start_date', '<=', time()],
                ['end_date', '>', time()],
            ])->orderBy('created_at', 'desc')->withPivot('include_variations');
    }

    // TODO: Add Tax Relation Function!
    
    /**
     * isDiscounted
     * 
     * Checks if price is discounted or not.
     * 
     * @return boolean
     */
    public function isDiscounted() {
        return $this->getBasePrice() - $this->getTotalPrice() > 0;
    }

    /**
     * Get the Total price
     *
     * NOTE: Total price is a price of the product after all discounts
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */

    // TODO: If Main Product of this variation is under a FlashDeal, take that Flash Deal into consideration too!
    // TODO: For now only flash deals which are directly related to specific ProductVariation are taken into consideration!!!

    // TODO: Create tax_relationship table and link it to subjects and taxes!
    // TODO: Create Global Taxes (as admin/single-vendor) or subject-specific taxes
    public function getTotalPrice(bool $display = false, bool $both_formats = false, $decimals = null): mixed
    {
        $decimals = is_int($decimals) ? $decimals : get_tenant_setting('no_of_decimals');

        if (empty($this->attributes[$this->getPriceColumn()])) {
            $this->total_price = 0;
        } elseif (empty($this->total_price)) {
            $this->total_price = (float) $this->attributes[$this->getPriceColumn()] ?? 0;

            if (method_exists($this, 'hasVariations') && $this->hasVariations()) {
                // TODO: Display lowest/highest variant total price OR SOME COMBINATION
                /*if ($flash_deal->discount_type === AmountPercentTypeEnum::percent()->value) {
                    $lowest_price -= ($lowest_price * $flash_deal_product->discount) / 100;
                    $highest_price -= ($highest_price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal->discount_type === AmountPercentTypeEnum::amount()->value) {
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }*/

                // TODO: Apply only flash deals which are compound!
                // Example: Vendor already created a flash deal for some products.
                // After few days, creates a flash deal for a category, or few other products where one of them is also included in the previous flash deal.
                // Which flash deal will take precedence?
                // TODO: We need to create a column which will determine flash_deal "stacking" type. Stacking type can be:
                // TODO: ~ 1) 'compound' (stacks with others), 2) 'single' (does not stack)

                if ((is_array($this->flash_deals) && ! empty($this->flash_deals)) || ($this->flash_deals instanceof Collection && $this->flash_deals->isNotEmpty())) {
                    $flash_deal = $this->flash_deals->first();

                    if ($flash_deal->discount_type === AmountPercentTypeEnum::percent()->value) {
                        $this->total_price -= ($this->total_price * $flash_deal->discount) / 100;
                    } elseif ($flash_deal->discount_type === AmountPercentTypeEnum::amount()->value) {
                        $this->total_price -= $flash_deal->discount;
                    }
                } else {
                    if ($this->discount_type === AmountPercentTypeEnum::percent()->value) {
                        $this->total_price -= ($this->total_price * $this->attributes['discount']) / 100;
                    } elseif ($this->discount_type === AmountPercentTypeEnum::amount()->value) {
                        $this->total_price -= $this->attributes['discount'];
                    }
                }
            } else {
                // NOTE: If FlashDeal is present for current product, DO NOT take Product's discount into consideration!
                if ((is_array($this->flash_deals) && ! empty($this->flash_deals)) || ($this->flash_deals instanceof Collection && $this->flash_deals->isNotEmpty())) {
                    $flash_deal = $this->flash_deals->first();

                    if ($flash_deal->discount_type === AmountPercentTypeEnum::percent()->value) {
                        $this->total_price -= ($this->total_price * $flash_deal->discount) / 100;
                    } elseif ($flash_deal->discount_type === AmountPercentTypeEnum::amount()->value) {
                        $this->total_price -= $flash_deal->discount;
                    }
                } else {
                    if ($this->discount_type === AmountPercentTypeEnum::percent()->value) {
                        $this->total_price -= ($this->total_price * $this->attributes['discount']) / 100;
                    } elseif ($this->discount_type === AmountPercentTypeEnum::amount()->value) {
                        $this->total_price -= $this->attributes['discount'];
                    }
                }
            }

            // Taxes
            // TODO: Create tax_relationships table and link it to subjects and taxes!
            // TODO: Create Global Taxes (as admin/single-vendor) or subject-specific taxes
            // $this->total_price = TaxService::appendTaxToPrice($this->total_price);
        }

        if ($both_formats) {
            return [
                'raw' => $this->total_price,
                'display' => FX::formatPrice($this->total_price, $decimals),
            ];
        }

        return $display ? FX::formatPrice($this->total_price, $decimals) : $this->total_price;
    }

    public function getTotalPriceAttribute()
    {
        return $this->getTotalPrice();
    }

    /**
     * Get Discounted price
     *
     * NOTE: Discounted price is a price of the product after all discounts, but without Tax included
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */
    public function getDiscountedPrice(bool $display = false, bool $both_formats = false, $decimals = null): mixed
    {
        $decimals = is_int($decimals) ? $decimals : get_tenant_setting('no_of_decimals');

        if (empty($this->attributes[$this->getPriceColumn()])) {
            $this->discounted_price = 0;
        } elseif (empty($this->discounted_price)) {
            $this->discounted_price = $this->attributes[$this->getPriceColumn()];

            if (method_exists($this, 'hasVariations') && $this->hasVariations()) {
                // TODO: Display lowest/highest variant total price OR SOME COMBINATION
                /*if ($flash_deal->discount_type === AmountPercentTypeEnum::percent()->value) {
                    $lowest_price -= ($lowest_price * $flash_deal_product->discount) / 100;
                    $highest_price -= ($highest_price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal->discount_type === AmountPercentTypeEnum::amount()->value) {
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }*/

                if ((is_array($this->flash_deals) && ! empty($this->flash_deals)) || ($this->flash_deals instanceof Collection && $this->flash_deals->isNotEmpty())) {
                    $flash_deal = $this->flash_deals->first();

                    if ($flash_deal->discount_type === AmountPercentTypeEnum::percent()->value) {
                        $this->discounted_price -= ($this->discounted_price * $flash_deal->discount) / 100;
                    } elseif ($flash_deal->discount_type === AmountPercentTypeEnum::amount()->value) {
                        $this->discounted_price -= $flash_deal->discount;
                    }
                } else {
                    if ($this->discount_type === AmountPercentTypeEnum::percent()->value) {
                        $this->discounted_price -= ($this->discounted_price * $this->attributes['discount']) / 100;
                    } elseif ($this->discount_type === AmountPercentTypeEnum::amount()->value) {
                        $this->discounted_price -= $this->attributes['discount'];
                    }
                }
            } else {
                // NOTE: If FlashDeal is present for current product, DO NOT take Product's discount into consideration!
                if ((is_array($this->flash_deals) && ! empty($this->flash_deals)) || ($this->flash_deals instanceof Collection && $this->flash_deals->isNotEmpty())) {
                    $flash_deal = $this->flash_deals->first();

                    if ($flash_deal->discount_type === AmountPercentTypeEnum::percent()->value) {
                        $this->discounted_price -= ($this->discounted_price * $flash_deal->discount) / 100;
                    } elseif ($flash_deal->discount_type === AmountPercentTypeEnum::amount()->value) {
                        $this->discounted_price -= $flash_deal->discount;
                    }
                } else {
                    if ($this->discount_type === AmountPercentTypeEnum::percent()->value) {
                        $this->discounted_price -= ($this->discounted_price * $this->attributes['discount']) / 100;
                    } elseif ($this->discount_type === AmountPercentTypeEnum::amount()->value) {
                        $this->discounted_price -= $this->attributes['discount'];
                    }
                }
            }
        }

        // $this->discounted_price = TaxService::appendTaxToPrice($this->discounted_price);

        if ($both_formats) {
            return [
                'raw' => $this->discounted_price,
                'display' => FX::formatPrice($this->discounted_price, $decimals),
            ];
        }

        return $display ? FX::formatPrice($this->discounted_price, $decimals) : $this->discounted_price;
    }

    public function getDiscountedPriceAttribute()
    {
        return $this->getDiscountedPrice();
    }

    /**
     * Get Base price (same as OriginalPrice)
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */
    public function getBasePrice(bool $display = false, bool $both_formats = false, $decimals = null): mixed
    {
        if (empty($this->attributes[$this->getPriceColumn()])) {
            $this->base_price = 0;
        } else {
            $this->base_price = $this->attributes[$this->getPriceColumn()];
        }

        // $this->base_price = TaxService::appendTaxToPrice($this->base_price);

        if ($both_formats) {
            return [
                'raw' => $this->base_price,
                'display' => FX::formatPrice($this->base_price, $decimals),
            ];
        }

        return $display ? FX::formatPrice($this->base_price, $decimals) : $this->base_price;
    }

    public function getBasePriceAttribute()
    {
        return $this->getBasePrice();
    }

    /**
     * Get Original price
     *
     * NOTE: Original price is the $this->getPriceColumn() of the product (without flash-deals/discounts/taxes etc.)
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */
    public function getOriginalPrice(bool $display = false, bool $both_formats = false, $decimals = null): mixed
    {
        return $this->getBasePrice($display, $both_formats, $decimals);
    }

    // Annual Prices (only for subscribable models)
    public function getBaseAnnualPrice(bool $display = false, bool $both_formats = false, $decimals = null)
    {
        try {
            if(isset($this->attributes[$this->getPriceColumn()])) {
                $this->base_annual_price = $this->attributes[$this->getPriceColumn()] * 12;
            } else if(!$this->isSubscribable()) {
                $this->base_annual_price = $this->attributes[$this->getPriceColumn()];
            } else {
                return 0;
            }

            // $this->base_annual_price = TaxService::appendTaxToPrice($this->base_annual_price);

            if ($both_formats) {
                return [
                    'raw' => $this->base_annual_price,
                    'display' => FX::formatPrice($this->base_annual_price, $decimals),
                ];
            }

            return $display ? FX::formatPrice($this->base_annual_price, $decimals) : $this->base_annual_price;
        } catch(\Throwable $e) {
            return 0;
        }
    }

    public function getBaseAnnualPriceAttribute()
    {
        return $this->getBaseAnnualPrice();
    }

    public function getTotalAnnualPrice(bool $display = false, bool $both_formats = false, $decimals = null)
    {
        try {
            /* This if is required for create to work */
            if(isset($this->attributes[$this->getPriceColumn()])) {
                $this->total_annual_price = $this->attributes[$this->getPriceColumn()] * 12;
            } else {
                return 0;
            }

            if ($this->isSubscribable()) {
                // First apply yearly discount, if any!
                if ($this->yearly_discount_type === AmountPercentTypeEnum::percent()->value) {
                    $this->total_annual_price -= ($this->total_annual_price * $this->attributes['yearly_discount']) / 100;
                } elseif ($this->yearly_discount_type === AmountPercentTypeEnum::amount()->value) {
                    $this->total_annual_price -= $this->attributes['yearly_discount'];
                }
                
                // TODO: Then add global Tax (like VAT)
            } else {
                // If item is not subscribable, annual price doesn't make sense, so it falls back to one-time total price
                $this->total_annual_price = $this->attributes[$this->getPriceColumn()];
            }

            // $this->total_annual_price = TaxService::appendTaxToPrice($this->total_annual_price);

            if ($both_formats) {
                return [
                    'raw' => $this->total_annual_price,
                    'display' => FX::formatPrice($this->total_annual_price, $decimals),
                ];
            }

            return $display ? FX::formatPrice($this->total_annual_price, $decimals) : $this->total_annual_price;
        } catch(\Throwable $e) {
            return 0;
        }
        
    }

    public function getTotalAnnualPriceAttribute()
    {
        return $this->getTotalAnnualPrice();
    }
    // END PRICES

}
