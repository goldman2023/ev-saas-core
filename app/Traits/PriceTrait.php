<?php

namespace App\Traits;

use App\Builders\BaseBuilder;
use App\Models\FlashDeal;
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
        static::addGlobalScope('withPricesAndTaxAndFlashDeals', function(mixed $builder) {
            // Eager Load Flash Deals
            $builder->with(['flash_deals']);
        });

        // When model relations data is retrieved, populate model prices data!
        static::relationsRetrieved(function ($model) {
            if(!$model->relationLoaded('flash_deals')) {
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
        $this->append(['total_price', 'discounted_price', 'base_price']);
    }

    /************************************
     * Price Relation Functions *
     ************************************/
    public function flash_deals() {
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
        if(empty($this->total_price)) {
            $this->total_price = $this->attributes[$this->getPriceColumn()];


            if(method_exists($this, 'hasVariations') && $this->hasVariations()) {
                // TODO: Display lowest/highest variant total price OR SOME COMBINATION
                /*if ($flash_deal->discount_type === 'percent') {
                    $lowest_price -= ($lowest_price * $flash_deal_product->discount) / 100;
                    $highest_price -= ($highest_price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal->discount_type === 'amount') {
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }*/

                // TODO: Apply only flash deals which are compound!
                // Example: Vendor already created a flash deal for some products.
                // After few days, creates a flash deal for a category, or few other products where one of them is also included in the previous flash deal.
                // Which flash deal will take precedence?
                // TODO: We need to create a column which will determine flash_deal "stacking" type. Stacking type can be:
                // TODO: ~ 1) 'compound' (stacks with others), 2) 'single' (does not stack)
                $flash_deal = $this->flash_deals->first();

                if(!empty($flash_deal)) {
                    if ($flash_deal->discount_type === 'percent') {
                        $this->total_price -= ($this->total_price * $flash_deal->discount) / 100;
                    } elseif ($flash_deal->discount_type === 'amount') {
                        $this->total_price -= $flash_deal->discount;
                    }
                } else {
                    if ($this->attributes['discount_type'] === 'percent') {
                        $this->total_price -= ($this->total_price * $this->attributes['discount']) / 100;
                    } elseif ($this->attributes['discount_type'] === 'amount') {
                        $this->total_price -= $this->attributes['discount'];
                    }
                }
            } else {
                $flash_deal = $this->flash_deals->first();

                // NOTE: If FlashDeal is present for current product, DO NOT take Product's discount into consideration!
                if(!empty($flash_deal)) {
                    if ($flash_deal->discount_type === 'percent') {
                        $this->total_price -= ($this->total_price * $flash_deal->discount) / 100;
                    } elseif ($flash_deal->discount_type === 'amount') {
                        $this->total_price -= $flash_deal->discount;
                    }
                } else {
                    if ($this->attributes['discount_type'] === 'percent') {
                        $this->total_price -= ($this->total_price * $this->attributes['discount']) / 100;
                    } elseif ($this->attributes['discount_type'] === 'amount') {
                        $this->total_price -= $this->attributes['discount'];
                    }
                }
            }

            // TODO: Create tax_relationships table and link it to subjects and taxes!
            // TODO: Create Global Taxes (as admin/single-vendor) or subject-specific taxes
            if(!empty($this->attributes['tax'])) {
                if ($this->attributes['tax_type'] === 'percent') {
                    $this->total_price += ($this->total_price * $this->attributes['tax']) / 100;
                } elseif ($this->attributes['tax_type'] === 'amount') {
                    $this->total_price += $this->attributes['tax'];
                }
            }

        }

        if ($both_formats) {
            return [
                'raw' => $this->total_price,
                'display' => FX::formatPrice($this->total_price)
            ];
        }

        return $display ? FX::formatPrice($this->total_price) : $this->total_price;
    }

    public function getTotalPriceAttribute() {
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
        if(empty($this->discounted_price)) {
            $this->discounted_price = $this->attributes[$this->getPriceColumn()];

            if(method_exists($this, 'hasVariations') && $this->hasVariations()) {
                // TODO: Display lowest/highest variant total price OR SOME COMBINATION
                /*if ($flash_deal->discount_type === 'percent') {
                    $lowest_price -= ($lowest_price * $flash_deal_product->discount) / 100;
                    $highest_price -= ($highest_price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal->discount_type === 'amount') {
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }*/
                $flash_deal = $this->flash_deals->first();

                if(!empty($flash_deal)) {
                    if ($flash_deal->discount_type === 'percent') {
                        $this->discounted_price -= ($this->discounted_price * $flash_deal->discount) / 100;
                    } elseif ($flash_deal->discount_type === 'amount') {
                        $this->discounted_price -= $flash_deal->discount;
                    }
                } else {
                    if ($this->attributes['discount_type'] === 'percent') {
                        $this->discounted_price -= ($this->discounted_price * $this->attributes['discount']) / 100;
                    } elseif ($this->attributes['discount_type'] === 'amount') {
                        $this->discounted_price -= $this->attributes['discount'];
                    }
                }
            } else {
                $flash_deal = $this->flash_deals->first();

                // NOTE: If FlashDeal is present for current product, DO NOT take Product's discount into consideration!
                if(!empty($flash_deal)) {
                    if ($flash_deal->discount_type === 'percent') {
                        $this->discounted_price -= ($this->discounted_price * $flash_deal->discount) / 100;
                    } elseif ($flash_deal->discount_type === 'amount') {
                        $this->discounted_price -= $flash_deal->discount;
                    }
                } else {
                    if ($this->attributes['discount_type'] === 'percent') {
                        $this->discounted_price -= ($this->discounted_price * $this->attributes['discount']) / 100;
                    } elseif ($this->attributes['discount_type'] === 'amount') {
                        $this->discounted_price -= $this->attributes['discount'];
                    }
                }
            }
        }

        if ($both_formats) {
            return [
                'raw' => $this->discounted_price,
                'display' => FX::formatPrice($this->discounted_price)
            ];
        }

        return $display ? FX::formatPrice($this->discounted_price) : $this->discounted_price;
    }

    public function getDiscountedPriceAttribute() {
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
        if(empty($this->base_price)) {
            $this->base_price = $this->attributes[$this->getPriceColumn()];

            // TODO: Create tax_relationship table and link it to subjects and taxes!
            // TODO: Create Global Taxes (as admin/single-vendor) or subject-specific taxes
            if(!empty($this->attributes['tax'])) {
                if ($this->attributes['tax_type'] === 'percent') {
                    $this->base_price += ($this->base_price * $this->attributes['tax']) / 100;
                } elseif ($this->attributes['tax_type'] === 'amount') {
                    $this->base_price += $this->attributes['tax'];
                }
            }
        }

        if ($both_formats) {
            return [
                'raw' => $this->base_price,
                'display' => FX::formatPrice($this->base_price)
            ];
        }

        return $display ? FX::formatPrice($this->base_price) : $this->base_price;
    }

    public function getBasePriceAttribute() {
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
                'raw' => $this->attributes[$price_column],
                'display' => FX::formatPrice($this->attributes[$price_column])
            ];
        }

        return $display ? FX::formatPrice($this->attributes[$price_column]) : $this->attributes[$price_column];
    }
    // END PRICES
}
