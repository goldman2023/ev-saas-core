<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log as FacadesLog;

use App\Facades\StripeService;

if (!function_exists('pix_pro_register_user')) {
    function pix_pro_register_user($user) {
        $route = pix_pro_endpoint().'/users/register_user/';

        $body = [
            "UserId" => $user->id,
            "FirstName" => $user->name,
            "LastName" => $user->surname,
            "Company" => '', // TODO: add company
            "UserPassword" => $user->getCoreMeta('password_md5', true),
            "UserEmail" => $user->email
        ];

        $response = Http::post($route, $body);
        $response_json = $response->json();

        if(!empty($response_json['status'] ?? null)) {
            // If status is not success for any reason, throw an error
            if($response_json['status'] !== 'success') {
                FacadesLog::error(pix_pro_error($route, 'There was an error while trying to create user in pix-pro API DB, check the response below.', $response_json));
            }
        }

    }
}

if (!function_exists('pix_pro_create_license')) {
    function pix_pro_create_license($user_subscriptions) {
        $route_trial = pix_pro_endpoint().'/trials/add_license/';
        $route_paid = pix_pro_endpoint().'/paid/add_license/';

        if ($user_subscriptions->isNotEmpty()) {
            foreach($user_subscriptions as $subscription) {

                $stripe_subscription_id = $subscription->data[StripeService::getStripeMode().'stripe_subscription_id'];

                $stripe_subscription = StripeService::stripe()->subscriptions->retrieve(
                    $stripe_subscription_id,
                    []
                  );

                $is_trial = !empty($stripe_subscription->trial_start ?? null) && !empty($stripe_subscription->trial_end ?? null);
                
                $body = [
                    "UserID" => $subscription->user_id,
                    "Qty" => 1, // THIS IS NUMBER OF TRIAL LICENSES TO BE CREATED! - WE SHOULD ALWAYS PUT 1, since we loop it on our end!
                    "LicenseType" => $is_trial ? 'trial':'full', // TODO: Can be `manual` too
                    "LicenseCloudService" => 0, // TODO: Take from plan attributes
                    "LicenseOfflineService" => 1, // TODO: Take from plan attributes
                    "LicenseImageLimit" => 150, // TODO: Take from plan attributes
                    "PackageType" => 'mining', // TODO: Take from plan attributes
                ];

                if(!$is_trial) {
                    // If license is not trial, append more params
                    $body['SubscriptionId'] = $subscription->id;
                    $body['LicenseSubscriptionType'] = $subscription->name;
                    $body['Status'] = 'active';
                    $body['PurchaseDate'] = date('Y-m-d H:i:s', $subscription->start_date);
                    $body['ExpirationDate'] = date('Y-m-d H:i:s', $subscription->end_date);
                    $body['OrderCurrency'] = $stripe_subscription->items->data[0]->price->currency ?? 'eur'; // TODO: This is different when multiplan is enabled
                    $body['Price'] = $stripe_subscription->items->data[0]->price->unit_amount / 100; // TODO: This is different when multiplan is enabled
                    $body['Tax'] = 21; // TODO: Make this respect Stripe tax!
                }

                $response = Http::post($is_trial ? $route_trial : $route_paid, $body);
                
                $response_json = $response->json();

                if(empty($response_json['status'] ?? null) || $response_json['status'] !== 'success') {
                    // If status is not success for any reason, throw an error
                    FacadesLog::error(pix_pro_error($is_trial ? $route_trial : $route_paid, 'There was an error while trying to create a license(order) in pix-pro API DB, check the response below.', $response_json));
                }
            }
        }
    }
}

// Basic PixPro API Config Functions
if (!function_exists('pix_pro_enabled')) {
    function pix_pro_enabled() {
        return get_tenant_setting('pix_pro_api_enabled', false);
    }
}
if (!function_exists('pix_pro_endpoint')) {
    function pix_pro_endpoint() {
        return rtrim(get_tenant_setting('pix_pro_api_endpoint', false), '/');
    }
}
if (!function_exists('pix_pro_username')) {
    function pix_pro_username() {
        return get_tenant_setting('pix_pro_api_username', false);
    }
}
if (!function_exists('pix_pro_password')) {
    function pix_pro_password() {
        return get_tenant_setting('pix_pro_api_password', false);
    }
}
if (!function_exists('pix_pro_error')) {
    function pix_pro_error($endpoint = null, $msg = '', $response_json = []) {
        return json_encode([
            'endpoint' => $endpoint,
            'msg' => $msg,
            'response' => $response_json,
        ]);
    };
}
