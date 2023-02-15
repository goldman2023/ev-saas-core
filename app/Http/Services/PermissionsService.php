<?php

namespace App\Http\Services;

use FX;
use WE;
use Cache;
use Session;
use App\Models\Shop;
use App\Models\User;
use App\Models\ShopSetting;
use App\Models\WeBaseModel;
use App\Models\TenantSetting;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class PermissionsService
{
    // This class is the main source of truth for all permissions and roles across the whole App!
    // IMPORTANT: After adding/removing/changing permissions, run `php artisan cache:forget spatie.permission.cache`
    protected $permissions;

    // Create a script that will feed the DB permissions table with all these permissions. Each time script is called, it should NOT update existing permissions, just add new!
    public function __construct($app = null, $init = true)
    {
        if ($init) {
            $this->permissions = app(config('permission.models.permission'))->select(['id', 'name', 'guard_name'])->get();
        }
    }

    public function canAccess(
        string|array|null $user_types = [], 
        string|array|null $permissions = [],
        bool $abort = true, 
        string|null $redirect_url = null, 
        \Closure|null $fallback = null,
        WeBaseModel|null $model = null,
        bool $allow_mine = true,
    )
    {
        // Super admin has the access to all pages!
        if ((auth()->user()?->user_type ?? null) === 'admin') {
            return true;
        }

        if(!empty($model) && isset($model->user_id) && $model->user_id === auth()->user()->id && $allow_mine) {
            return true;
        }

        if (in_array(auth()->user()->user_type, $user_types, true) &&
            (empty($permissions) || auth()->user()->hasAnyDirectPermission($permissions))) {
            return true;
        } else {
            // If there's no enough permissions, check if $fallback Closure is defined and check if return value is true
            if(!empty($fallback) && $fallback instanceof \Closure) {
                if($fallback() === true) {
                    return true;
                }
            }
        }

        if(!empty($redirect_url)) {
            redirect_now($redirect_url);
        }

        if($abort) {
            abort(403);
        }

        return false;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function getUserPermissions(User|int|null $user, $key_by = 'name')
    {
        if (empty($user)) {
            return collect();
        }

        if (is_int($user)) {
            $user = User::find($user);
        }

        $user_permissions = DB::table(config('permission.table_names.model_has_permissions'))
                                ->where('model_id', '=', $user->id)
                                ->where('model_type', '=', $user::class)
                                ->get()->keyBy('permission_id')->toArray();

        return collect($this->permissions->toArray())
                ->map(fn ($item) => array_merge($item, ['selected' => isset($user_permissions[$item['id']])]))->keyBy($key_by);
    }

    public function getRoleNames() {
        $data = app(config('permission.models.role'))->with('permissions')->get();

        return $data->pluck('name');
    }

    public function getRoles($only_role_names = false, $from_db = true)
    {
        if ($from_db) {
            $data = app(config('permission.models.role'))->with('permissions')->get();

            if ($only_role_names) {
                return $data->pluck('name');
            }
        } else {
            $data = collect([
                'Owner' => array_merge(
                    $this->getShopPermissions(),
                    $this->getStaffPermissions(),
                    $this->getOrdersPermissions(),
                    $this->getProductPermissions(),
                    $this->getPlansPermissions(),
                    $this->getReviewsPermissions(),
                    $this->getBlogPostsPermissions(),
                    $this->getCustomersPermissions(),
                    // $this->getPaymentsPermissions(),
                    // $this->getDesignsPermissions(),
                    $this->getLeadsPermissions()
                ),
                'Editor' => array_merge(
                    $this->getProductPermissions(),
                    $this->getBlogPostsPermissions(),
                    $this->getReviewsPermissions(),
                    $this->getOrdersPermissions(),
                    $this->getLeadsPermissions(),
                    $this->getPlansPermissions()
                ),
                'HR' => array_merge(
                    $this->getStaffPermissions(),
                    $this->getReviewsPermissions(),
                    [
                        'view_shop_data' => 'View shop data',
                        'view_shop_settings' => 'View shop settings',
                        'browse_shop_domains' => 'Browse shop domains',
                    ]
                ),
                // More roles should be added later, like: Marketer, Manager of XZY, {whatever} etc.
            ]);

            if ($only_role_names) {
                return $data->keys();
            }
        }

        return $data;
    }

    public function getRolePermissions($role_name)
    {
        return array_keys($this->getRoles(from_db: false)->get($role_name));
        // return Role::where('name', $role_name)->first()->permissions->pluck('id'); // this is from DB
    }

    public function getAllPossiblePermissions()
    {
        return collect(array_merge(
            $this->getShopPermissions(),
            $this->getStaffPermissions(),
            $this->getOrdersPermissions(),
            $this->getProductPermissions(),
            $this->getPlansPermissions(),
            $this->getReviewsPermissions(),
            $this->getBlogPostsPermissions(),
            $this->getCustomersPermissions(),
            $this->getPaymentsPermissions(),
            $this->getDesignsPermissions(),
            $this->getLeadsPermissions()
        ));
    }

    public function getAllPermissionsGroupsFunctionNames()
    {
        return [
            translate('Shop') => 'getShopPermissions',
            translate('Staff') => 'getStaffPermissions',
            translate('Customers') => 'getCustomersPermissions',
            translate('Orders') => 'getOrdersPermissions',
            translate('Products') => 'getProductPermissions',
            translate('Plans') => 'getPlansPermissions',
            translate('Blog Posts') => 'getBlogPostsPermissions',
            translate('Reviews') => 'getReviewsPermissions',
            translate('Leads') => 'getLeadsPermissions',
            translate('Payment Methods Universal') => [
                'fname' => 'getPaymentsPermissions',
                'user_types' => User::$tenant_user_types,
            ],
            translate('Design') => 'getDesignsPermissions',
        ];
    }

    public function getShopPermissions()
    {
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

    public function getStaffPermissions()
    {
        return [
            'browse_staff' => 'Browse staff members',
            'view_staff' => 'View staff member',
            'insert_staff' => 'Create staff member',
            'update_staff' => 'Update staff member',
            'delete_staff' => 'Delete staff member',
            'ban_staff' => 'Ban staff member',
        ];
    }

    public function getProductPermissions()
    {
        return [
            'all_products' => 'Allow managing all products',
            'browse_products' => 'Browse products',
            'view_product' => 'View product',
            'update_product' => 'Update product',
            'insert_product' => 'Create product',
            'delete_product' => 'Delete product',
            'publish_product' => 'Publish product',
            //            'unpublish_product' => 'Unpublish product',
            'update_product_stock' => 'Update product stock',
            'view_product_attributes' => 'View product attributes',
            'insert_product_attributes' => 'Create product attributes',
            'update_product_attributes' => 'Update product attributes',
            'delete_product_attributes' => 'Delete product attributes',
            // Maybe add 'manage product stock' ?
        ];
    }

    public function getOrdersPermissions()
    {
        return [
            'all_orders' => 'Allow accessing all orders',
            'browse_orders' => 'Browse orders',
            'view_order' => 'View order',
            'insert_order' => 'Create order',
            'update_order' => 'Update order',
            'update_order_status' => 'Update order status',
            'delete_order' => 'Delete order',
        ];
    }

    public function getBlogPostsPermissions()
    {
        return [
            'all_posts' => 'Allow managing all blog posts',
            'browse_posts' => 'Browse blog posts',
            'view_post' => 'View blog post',
            'insert_post' => 'Create blog post',
            'update_post' => 'Update blog post',
            //            'update_post_status' => 'Update blog post status',
            'publish_post' => 'Publish blog post',
            'delete_post' => 'Delete blog post',
            'view_post_attributes' => 'View blog post attributes',
            'insert_post_attributes' => 'Create blog post attributes',
            'update_post_attributes' => 'Update blog post attributes',
            'delete_post_attributes' => 'Delete blog post attributes',
        ];
    }

    public function getReviewsPermissions()
    {
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

    public function getCustomersPermissions()
    {
        return [
            'all_customers' => 'Allow managing all customers',
            'browse_customers' => 'Browse customers',
            'view_customer' => 'View customer',
        ];
    }

    public function getDesignsPermissions()
    {
        return [
            'browse_designs' => 'Browse designs',

        ];
    }

    public function getPaymentsPermissions()
    {
        return [
            'browse_uni_payment_methods' => 'Browse uni. payment methods',
            'view_uni_payment_methods' => 'View uni. payment method',
            'insert_uni_payment_methods' => 'Insert uni. payment methods',
            'update_uni_payment_methods' => 'Update uni. payment methods',
            'delete_uni_payment_methods' => 'Delete uni. payment methods',
        ];
    }

    public function getLeadsPermissions()
    {
        return [
            'all_leads' => 'All leads',
            'browse_leads' => 'Browse leads',
            'view_lead' => 'View lead',
            'insert_leads' => 'Create leads',
            'update_leads' => 'Update leads',
            'delete_leads' => 'Delete leads',
        ];
    }

    public function getPlansPermissions()
    {
        return [
            'all_plans' => 'Allow managing all plans',
            'browse_plans' => 'Browse plans',
            'view_plan' => 'View plan',
            'insert_plan' => 'Create plan',
            'update_plan' => 'Update plan',
            'delete_plan' => 'Delete plan',
            'publish_plan' => 'Publish plan',
            'view_plan_attributes' => 'View plan attributes',
            'insert_plan_attributes' => 'Create plan attributes',
            'update_plan_attributes' => 'Update plan attributes',
            'delete_plan_attributes' => 'Delete plan attributes',
        ];
    }

    
}
