<?php

namespace App\Http\Services;

use App\Models\AttributeGroup;
use App\Models\Shop;
use Vendor;
use App\Models\Category;
use App\Models\CategoryRelationship;
use App\Models\Product;
use Cache;
use Illuminate\Support\Collection;
use Str;

class AttributesService
{
    public $app;

    // TODO: Add caching for vendor-specific attribute groups, if any!
    protected mixed $vendor_attribute_groups = null;

    // TODO: Add caching for site-wide attribute groups
    protected mixed $site_wide_attribute_groups = null;

    public function __construct($app)
    {
        $this->app = $app;

        // TODO: Take care of attribute groups ORDERING! Which comes first when displaying the data on FE!

        if(Vendor::isVendorSite()) {
            // Return only a) `site-wide`(added by admins) and b) `specific vendor`, attribute groups
            $this->vendor_attribute_groups = AttributeGroup::whereNull('shop_id')->orWhere('shop_id', Vendor::getVendorShop()->id)->orderBy('shop_id', 'asc')->get();
            $this->site_wide_attribute_groups = $this->vendor_attribute_groups->whereNull('shop_id');
        } else {
            $this->site_wide_attribute_groups = AttributeGroup::whereNull('shop_id')->get();
        }
    }

    /**
     * Get all categories in a tree structured collection
     *
     * @param integer|Shop|null $shop
     * @return array
     */
    public function getGroups(int|Shop $shop = null) {
        if(Vendor::isVendorSite()) {
            // Return only a) `site-wide`(added by admins) and b) `specific vendor`, attribute groups
            return $this->vendor_attribute_groups;
        }

        // Return only `site-wide` attribute groups + attribute groups `added by specific vendor`
        // TODO: Take care of attribute groups ORDERING! Which comes first when displaying the data on FE etc.!
        if($shop instanceof Shop || is_numeric($shop)) {
            // TODO: Add caching for site-wide and specific vendor attribute groups!
            return AttributeGroup::whereNull('shop_id')->orWhere('shop_id', ($shop instanceof Shop) ? $shop->id : $shop)->orderBy('shop_id', 'asc')->get(); // site-wide first, shop-specific after
        }

        // Return only `site-wide` attribute groups
        return $this->site_wide_attribute_groups;
    }

    /**
     * Return Generic AttributeGroup instance
     *
     * @return AttributeGroup
     */
    public function newGroupInstance($custom_attributes = null): AttributeGroup
    {
        $instance = new AttributeGroup();
        $instance->name = 'Generic';
        $instance->order = 0;
        $instance->shop_id = null;
        $instance->custom_attributes = $custom_attributes;

        return $instance;
    }
}
