<?php

namespace App\Traits;

use FX;

trait PriceTrait
{
    public mixed $total_price;
    public mixed $discounted_price;
    public mixed $base_price;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootPriceTrait()
    {
        // When model data is retrieved, populate model prices data!
        static::retrieved(function ($model) {
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

    /**
     * Get the Total price
     *
     * NOTE: Total price is a price of the product after all discounts and with Tax included
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */
    public function getTotalPrice(bool $display = false, bool $both_formats = false): mixed
    {
        if(empty($this->total_price)) {
            $this->total_price = $this->attributes['unit_price'];

            if($this->has_variations()) {
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
            $this->discounted_price = $this->attributes['unit_price'];

            if($this->has_variations()) {
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
            $this->base_price = $this->attributes['unit_price'];

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
     * NOTE: Original price is the unit_price of the product (without flash-deals/discounts/taxes etc.)
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */
    public function getOriginalPrice(bool $display = false, bool $both_formats = false): mixed
    {
        if ($both_formats) {
            return [
                'raw' => $this->attributes['unit_price'],
                'display' => FX::formatPrice($this->attributes['unit_price'])
            ];
        }

        return $display ? FX::formatPrice($this->attributes['unit_price']) : $this->attributes['unit_price'];
    }
    // END PRICES
}
