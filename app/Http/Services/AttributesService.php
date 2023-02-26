<?php

namespace App\Http\Services;

use Str;
use Cache;
use Vendor;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\AttributeGroup;
use Illuminate\Support\Collection;
use App\Models\CategoryRelationship;

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

        if (Vendor::isVendorSite()) {
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
     * @param int|Shop|null $shop
     * @return array
     */
    public function getGroups(int|Shop $shop = null)
    {
        if (Vendor::isVendorSite()) {
            // Return only a) `site-wide`(added by admins) and b) `specific vendor`, attribute groups
            return $this->vendor_attribute_groups;
        }

        // Return only `site-wide` attribute groups + attribute groups `added by specific vendor`
        // TODO: Take care of attribute groups ORDERING! Which comes first when displaying the data on FE etc.!
        if ($shop instanceof Shop || is_numeric($shop)) {
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

    public function getFilterableProductAttrbiutes() {
        return Attribute::forProduct()->filterable()->get();

        return $attributes;
    }

    public function castFilterableProductAttributesFromQueryParams(&$attributes = null, $remove_inactive = false) {
        $selected_attributes = [];
        $count_active_filters = 0;
        $query_params = request()->query();

        if(empty($attributes)) {
            $attributes = AttributesService::getFilterableProductAttrbiutes();
        }
        
        foreach($attributes as $attribute) {
            if(in_array($attribute['type'], ['dropdown', 'checkbox'])) {
                $selected_attributes[$attribute->slug] = [];
            } else {
                $selected_attributes[$attribute->slug] = null;
            }

            if(isset($query_params[$attribute->slug])) {
                if($attribute['type'] === 'toggle') {
                    $query_params[$attribute->slug] = (boolean) $query_params[$attribute->slug];
                }

                if($query_params[$attribute->slug] !== 'all' && $query_params[$attribute->slug] !== false) {
                    $count_active_filters += 1;
                }

                $selected_attributes[$attribute->slug] = $query_params[$attribute->slug];
            }
        }

        return [
            'selected_attributes' => $remove_inactive ? $this->removeInactiveFilteredAttributes($selected_attributes) : $selected_attributes,
            'count_active_filters' => $count_active_filters
        ];
    }

    public function removeInactiveFilteredAttributes(&$selected_attributes = []) {
        $attributes = AttributesService::getFilterableProductAttrbiutes();

        foreach($selected_attributes as $selected_att_slug => $selected_att_value) {
            $att = $attributes->firstWhere('slug', $selected_att_slug);
            
            if(empty($selected_att_value) || $selected_att_value === 'all') {
                unset($selected_attributes[$selected_att_slug]);
            }
        }

        return $selected_attributes;
    }
}
