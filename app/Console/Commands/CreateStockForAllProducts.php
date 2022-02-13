<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Central\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateStockForAllProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create_product_stock {--tenant_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creeate stock for all produts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get tenatn ID from option
        $tenant_id = $this->option('tenant_id');
        $tenant = Tenant::findOrFail($tenant_id);

        // Init tenant
        tenancy()->initialize($tenant);

        $products = \App\Models\Product::all();
        foreach ($products as $product) {
            if(!$product->stock instanceof \App\Models\ProductStock || empty($product)) {
                if($product->hasVariations()) {
                    // model has variations
                    $variations = $product->variations;

                    foreach($variations as $variation) {
                        $stock = new \App\Models\ProductStock();
                        $stock->subject_id = $variation->id;
                        $stock->subject_type = $variation::class;
                        $stock->sku = $product->slug.'-'.$variation->getVariantName(slugified: true);
                        $stock->qty = 0;
                        $stock->low_stock_qty = 0;
                        $stock->use_serial = 0;
                        $stock->save();
                    }
                } else {
                    // simple model
                    $stock = new \App\Models\ProductStock();
                    $stock->subject_id = $product->id;
                    $stock->subject_type = $product::class;
                    $stock->sku = $product->slug;
                    $stock->qty = 0;
                    $stock->low_stock_qty = 0;
                    $stock->use_serial = 0;
                    $stock->save();
                }
                
            }
        }
        
        dd();
    }
}
