<?php

use App\Models\Shop;
use App\Models\ShopSetting;
use App\Models\TenantSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('business_settings', 'tenant_settings');

        Schema::create('shop_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('shop_id');
            $table->string('setting');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['shop_id', 'setting']);
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->unique('slug');
        });

        Schema::table('tenant_settings', function (Blueprint $table) {
            $table->renameColumn('type', 'setting');
            $table->index('setting');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('shop_settings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /* TODO: Properly define which settings are for tenant and which are for vendor!!! Also, when new tenant is created add tenant-settings, do the same when shop is created but with shop-settings */
        $settings = TenantSetting::all();
        $shops = Shop::all();
        foreach ($shops as $shop) {
            foreach ($settings as $setting) {
                try {
                    $shop_settings = new ShopSetting();
                    $shop_settings->shop_id = $shop->id;
                    $shop_settings->setting = $setting->setting;
                    $shop_settings->value = is_array($setting->value) ? json_encode($setting->value) : $setting->value;
                    $shop_settings->save();
                } catch (\Exception $e) {
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('tenant_settings', 'business_settings');
    }
};
