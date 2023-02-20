<?php

namespace App\Http\Services;

use FX;
use WE;
use Cache;
use Session;
use App\Models\Shop;
use App\Models\ProductAddon;
use Illuminate\Database\Eloquent\Collection;

class TaxService
{
    public $app;
    public $include_tax;
    public $globalTaxPercentage; // TODO: Make tax system in taxes table which depend on country! For now we are just adding global tax to everyone...

    public function __construct($app)
    {
        $this->app = $app();

        $this->include_tax = (boolean) get_tenant_setting('include_tax');

        try {
            $this->globalTaxPercentage = (float) get_tenant_setting('company_tax_rate');
            if(empty($this->globalTaxPercentage)) {
                $this->globalTaxPercentage = 0;
            }
        } catch(\Exception $e)  {
            $this->globalTaxPercentage = 0;
        }
        
    }

    public function getGlobalTaxPercentage()
    {
        return $this->globalTaxPercentage;
    }

    public function isTaxIncluded()
    {
        return $this->include_tax;
    }

    public function appendTaxToPrice($price) {
        if($this->isTaxIncluded()) {
            $price = $price + ($price * $this->getGlobalTaxPercentage() / 100);
        }

        return $price;
    }

    public function calculateTaxAmount($amount) {
        if($this->isTaxIncluded()) {
            return ($amount * 100 / (100 + $this->getGlobalTaxPercentage())) * $this->getGlobalTaxPercentage() / 100;
        } else {
            return $amount * $this->getGlobalTaxPercentage() / 100;
        }
    }

    public function calculatePriceWithTax($price) {
        // Add tax to price only if tax is not already included in price itself!
        if(!$this->isTaxIncluded()) {
            $price = $price + $this->calculateTaxAmount($price);
        }

        return $price;
    }
}
