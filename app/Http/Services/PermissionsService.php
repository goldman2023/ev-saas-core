<?php

namespace App\Http\Services;

use App\Models\Shop;
use App\Models\ShopSetting;
use App\Models\TenantSetting;
use App\Models\User;
use Cache;
use Illuminate\Database\Eloquent\Collection;
use Session;
use EVS;
use FX;

class PermissionsService
{

    // Create a script that will feed the DB permissions table with all these permissions. Each time script is called, it should NOT update existing permissions, just add new!
    public function __construct($app = null)
    {

    }

    public function getAllPermissions() {
        return collect(array_merge(
            $this->getShopPermissions(),
            $this->getStaffPermissions(),
            $this->getOrdersPermissions(),
            $this->getProductPermissions(),
            $this->getReviewsPermissions(),
            $this->getBlogPermissions()
        ));
    }


    public function getShopPermissions() {
        return [
            'view_shop_data' => 'View shop data',
            'update_shop_data' => 'Update shop data',
            'view_shop_settings' => 'View shop settings',
            'update_shop_settings' => 'Update shop settings',
            'browse_shop_domains' => 'Browse shop domains',
            'insert_shop_domains' => 'Insert shop domains',
            'update_shop_domains' => 'Update shop domains',
            'delete_shop_domains' => 'Delete shop domains',
        ];
    }

    public function getStaffPermissions() {
        return [
            'browse_staff' => 'Browse staff members',
            'view_staff' => 'View staff member',
            'insert_staff' => 'Create staff member',
            'update_staff' => 'Update staff member',
            'delete_staff' => 'Delete staff member',
            'ban_staff' => 'Ban staff member',
        ];
    }

    public function getProductPermissions() {
        return [
            'see_all_products' => 'See all shop\'s products',
            'view_product' => 'View product',
            'update_product' => 'Update product',
            'insert_product' => 'Create product',
            'delete_product' => 'Delete product',
            'publish_product' => 'Publish product',
            'unpublish_product' => 'Unpublish product',
            'update_product_stock' => 'Update product stock',
            'view_product_attributes' => 'View product attributes',
            'insert_product_attributes' => 'Create product attributes',
            'update_product_attributes' => 'Update product attributes',
            'delete_product_attributes' => 'Delete product attributes',
            // Maybe add 'Update product variations' ?
        ];
    }

    public function getOrdersPermissions() {
        return [
            'browse_orders' => 'Browse orders',
            'view_order' => 'View order',
            'insert_order' => 'Create order',
            'update_order' => 'Update order',
            'update_order_status' => 'Update order status',
            'delete_order' => 'Delete order',
        ];
    }

    public function getBlogPermissions() {
        return [
            'browse_posts' => 'Browse posts',
            'view_post' => 'View post',
            'insert_post' => 'Create post',
            'update_post' => 'Update post',
            'update_post_status' => 'Update post status',
            'delete_post' => 'Delete post',
            'view_product_attributes' => 'View post attributes',
            'insert_product_attributes' => 'Create post attributes',
            'update_product_attributes' => 'Update post attributes',
            'delete_product_attributes' => 'Delete post attributes',
        ];
    }

    public function getReviewsPermissions() {
        return [
            'browse_reviews' => 'Browse reviews',
            'view_review' => 'View review',
            'insert_review' => 'Create review',
            'update_review' => 'Update review',
            'delete_review' => 'Delete review',
            'approve_review' => 'Approve review',
            'disapprove_review' => 'Disapprove review',
        ];
    }
}
