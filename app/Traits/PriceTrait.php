<?php

namespace App\Traits;

use App\Builders\BaseBuilder;
use App\Enums\AmountPercentTypeEnum;
use App\Models\FlashDeal;
use App\Models\Plan;
use FX;

trait PriceTrait
{
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
            // dd($builder);
        });

        // When model relations data is retrieved, populate model prices data!
        static::relationsRetrieved(function ($model) {
            if (! $model->relationLoaded('flash_deals')) {
                $model->load('flash_deals');
            }

            $model->getTotalPrice();
            $model->getDiscountedPrice();
            $model->getBasePrice();
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializePriceTrait(): void
    {
        $this->appendCoreProperties(['total_price', 'discounted_price', 'base_price']);
        $this->append(['total_price', 'discounted_price', 'base_price']);

        // These calculated prices ARE NOT FILLABLE! They are calculated based on other properties!
        // $this->fillable(array_unique(array_merge($this->fillable, ['total_price', 'discounted_price', 'base_price'])));
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
     * Get the Total price
     *
     * NOTE: Total price is a price of the product after all discounts and with Tax included
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */

    // TODO: If Main Product of this variation is under a FlashDeal, take that Flash Deal into consideration too!
    // TODO: For now only flash deals which are directly related to specific ProductVariation are taken into consideration!!!

    // TODO: Create tax_relationship table and link it to subjects and taxes!
    // TODO: Create Global Taxes (as admin/single-vendor) or subject-specific taxes
    public function getTotalPrice(bool $display = false, bool $both_formats = false): mixed
    {
        if (empty($this->attributes[$this->getPriceColumn()])) {
            $this->total_price = 0;
        } elseif (empty($this->total_price)) {
            $this->total_price = $this->attributes[$this->getPriceColumn()] ?? 0;

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

            // TODO: Create tax_relationships table and link it to subjects and taxes!
            // TODO: Create Global Taxes (as admin/single-vendor) or subject-specific taxes
            if (! empty($this->attributes['tax'])) {
                if ($this->attributes['tax_type'] === AmountPercentTypeEnum::percent()->value) {
                    $this->total_price += ($this->total_price * $this->attributes['tax']) / 100;
                } elseif ($this->attributes['tax_type'] === AmountPercentTypeEnum::amount()->value) {
                    $this->total_price += $this->attributes['tax'];
                }
            }
        }

        if ($both_formats) {
            return [
                'raw' => $this->total_price,
                'display' => FX::formatPrice($this->total_price),
            ];
        }

        return $display ? FX::formatPrice($this->total_price) : $this->total_price;
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
    public function getDiscountedPrice(bool $display = false, bool $both_formats = false): mixed
    {
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

        if ($both_formats) {
            return [
                'raw' => $this->discounted_price,
                'display' => FX::formatPrice($this->discounted_price),
            ];
        }

        return $display ? FX::formatPrice($this->discounted_price) : $this->discounted_price;
    }

    public function getDiscountedPriceAttribute()
    {
        return $this->getDiscountedPrice();
    }

    /**
     * Get Base price
     *
     * NOTE: Base price is the price of the product with product related taxes
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */
    public function getBasePrice(bool $display = false, bool $both_formats = false): mixed
    {
        if (empty($this->attributes[$this->getPriceColumn()])) {
            $this->base_price = 0;
        } elseif (empty($this->base_price)) {
            $this->base_price = $this->attributes[$this->getPriceColumn()];

            // TODO: Create tax_relationship table and link it to subjects and taxes!
            // TODO: Create Global Taxes (as admin/single-vendor) or subject-specific taxes
            if (! empty($this->attributes['tax'])) {
                if ($this->attributes['tax_type'] === AmountPercentTypeEnum::percent()->value) {
                    $this->base_price += ($this->base_price * (float) $this->attributes['tax']) / 100;
                } elseif ($this->attributes['tax_type'] === AmountPercentTypeEnum::amount()->value) {
                    $this->base_price += $this->attributes['tax'];
                }
            }
        }

        if ($both_formats) {
            return [
                'raw' => $this->base_price,
                'display' => FX::formatPrice($this->base_price),
            ];
        }

        return $display ? FX::formatPrice($this->base_price) : $this->base_price;
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
    public function getOriginalPrice(bool $display = false, bool $both_formats = false): mixed
    {
        $price_column = $this->getPriceColumn();

        if ($both_formats) {
            return [
                'raw' => $this->attributes[$price_column] ?? 0,
                'display' => FX::formatPrice($this->attributes[$price_column] ?? 0),
            ];
        }

        return $display ? FX::formatPrice($this->attributes[$price_column] ?? 0) : $this->attributes[$price_column] ?? 0;
    }
    // END PRICES

    public function getTotalAnnualPrice(bool $display = false, bool $both_formats = false)
    {
        $total_annual_price = $this->attributes[$this->getPriceColumn()] * 12;

        if ($this instanceof Plan) {
            // First apply yearly discount, if any!
            if ($this->yearly_discount_type === AmountPercentTypeEnum::percent()->value) {
                $total_annual_price -= ($total_annual_price * $this->attributes['yearly_discount']) / 100;
            } elseif ($this->yearly_discount_type === AmountPercentTypeEnum::amount()->value) {
                $total_annual_price -= $this->attributes['yearly_discount'];
            }

            // Then, add Plan specific Tax, if any
            if ($this->tax_type === AmountPercentTypeEnum::percent()->value) {
                $total_annual_price += ($total_annual_price * $this->attributes['tax']) / 100;
            } elseif ($this->tax_type === AmountPercentTypeEnum::amount()->value) {
                $total_annual_price += $this->attributes['tax'];
            }

            // TODO: Then add global Tax (like VAT)
        }

        if ($both_formats) {
            return [
                'raw' => $total_annual_price,
                'display' => FX::formatPrice($total_annual_price),
            ];
        }

        return $display ? FX::formatPrice($total_annual_price) : $total_annual_price;
    }
}
