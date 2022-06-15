<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Facades\StripeService;
use App\Models\License;
use Illuminate\Support\Facades\DB;

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
                Log::error(pix_pro_error($route, 'There was an error while trying to create user in pix-pro API DB, check the response below.', $response_json));
                return false;
            } else {
                return true;
            }
        }

        return false;
    }
}

// ACTIVATE LICENSE
if (!function_exists('pix_pro_activate_license')) {
    function pix_pro_activate_license($user, $serial_number, $hardware_id) {
        $route = pix_pro_endpoint().'/licenses/activate_paid_license/';

        $body = pix_pro_add_auth_params([
            "UserPassword" => $user->getCoreMeta('password_md5', true),
            "UserEmail" => $user->email,
            "UserSn" => $serial_number,
            "HardwareId" => $hardware_id,
        ]);

        $response = Http::post($route, $body);
        $response_json = $response->json();

        if(!empty($response_json['status'] ?? null)) {
            // If status is not success for any reason, throw an error
            if($response_json['status'] !== 'success') {
                Log::error(pix_pro_error($route, 'There was an error while trying to activate your license.', $response_json));

                if(!empty($response_json['error_id'] ?? null)) {
                    // deactivate previously set hardware_id
                    // pix_pro_disconnect_license();
                }
            }

            return $response_json;
        }

        return null;
    }
}

// DOWNLOAD .DAT
if (!function_exists('pix_pro_download_license')) {
    function pix_pro_download_license($license_id, $user) {
        $route = pix_pro_endpoint().'/licenses/download_license/';

        $body = pix_pro_add_auth_params([
            "UserPassword" => $user->getCoreMeta('password_md5', true),
            "UserEmail" => $user->email,
            "LicenseId" => $license_id,
        ]);

        $response = Http::post($route, $body);
        $response_json = $response->json();

        if(!empty($response_json['status'] ?? null)) {
            // If status is not success for any reason, throw an error
            if($response_json['status'] !== 'success') {
                Log::error(pix_pro_error($route, 'There was an error while trying to download your license .dat file.', $response_json));
                return null;
            } else {
                return $response_json;
            }
        }

        return null;
    }
}

if (!function_exists('pix_pro_download_license_logic')) {
    function pix_pro_download_license_logic($license) {
        try {
            $response = pix_pro_download_license($license->data['id'] ?? -1, auth()->user());

            if(!empty($response)) {
                return $response;
            }

            $this->inform(translate('Error: Cannot download license .DAT file...'), translate('Serial number: ').$license->serial_number, 'fail');
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            dd($e);
        }
    }
}

if (!function_exists('pix_pro_disconnect_license')) {
    function pix_pro_disconnect_license($license, $user, $form) {
        try {
            $route = pix_pro_endpoint().'/licenses/deactivate_license_hw_id/';

            $body = pix_pro_add_auth_params([
                "UserPassword" => $user->getCoreMeta('password_md5', true),
                "UserEmail" => $user->email,
                "LicenseId" => $license->data['id'] ?? '',
                "HardwareId" => $license->data['hardware_id'] ?? ''
            ]);

            $response = Http::post($route, $body);
            $response_json = $response->json();

            if(!empty($response_json['status'] ?? null)) {
                // If status is not success for any reason, throw an error
                if($response_json['status'] !== 'success') {
                    Log::error(pix_pro_error($route, 'There was an error while trying to disconnect a license.', translate('Serial number: ').$license->serial_number , $response_json));
                    return null;
                } else {
                    // Disconnect license on our end
                    $data = $license->data;
                    $data['hardware_id'] = null;
                    $license->data = $data;
                    $license->save();

                    $form->inform(translate('You successfully disconnected your license!'), translate('Serial number: ').$license->serial_number, 'success');
                    return $response_json;
                }
            }

            $form->inform(translate('Error: Cannot disconnect license from hardware...'), translate('Serial number: ').$license->serial_number, 'fail');
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            dd($e);
        }
    }
}


// CREATE LICENSE
if (!function_exists('pix_pro_create_license')) {
    function pix_pro_create_license($user_subscriptions, $stripe_invoice) {
        $route_trial = pix_pro_endpoint().'/paid/add_license/'; //pix_pro_endpoint().'/trials/add_license/';
        $route_paid = pix_pro_endpoint().'/paid/add_license/';

        if ($user_subscriptions->isNotEmpty()) {
            foreach($user_subscriptions as $subscription) {

                $stripe_subscription_id = $subscription->data[StripeService::getStripeMode().'stripe_subscription_id'];

                $stripe_subscription = StripeService::stripe()->subscriptions->retrieve(
                    $stripe_subscription_id,
                    []
                  );

                $is_trial = !empty($stripe_subscription->trial_start ?? null) && !empty($stripe_subscription->trial_end ?? null);

                $pix_pro_user = pix_pro_get_user($subscription->user)['data'] ?? [];

                if(!empty($pix_pro_user['user_id'] ?? null)) {
                    $number_of_images = $subscription->getCoreMeta('number_of_images');
                    
                    if(!empty($number_of_images) && (is_int($number_of_images || ctype_digit($number_of_images)))) {
                        $number_of_images = $subscription->getCoreMeta('number_of_images') ?? 150;
                    } else {
                        $number_of_images = 150;
                    }

                    $body = pix_pro_add_auth_params([
                        "UserEmail" => $pix_pro_user['email'],
                        "UserPassword" => $subscription->user->getCoreMeta('password_md5'),
                        "Qty" => 1, // THIS IS NUMBER OF TRIAL LICENSES TO BE CREATED! - WE SHOULD ALWAYS PUT 1, since we loop it on our end!
                        "LicenseType" => 'full', // TODO: Can be `manual` too
                        "LicenseCloudService" => $subscription->getCoreMeta('includes_cloud') === true ? 1 : 0,
                        "LicenseOfflineService" => $subscription->getCoreMeta('includes_offline') === true ? 1 : 0,
                        "LicenseImageLimit" => $number_of_images,
                        "PackageTypes" => 'mining',
                    ]);

                    // if(!$is_trial) {
                        // If license is not trial, append more params
                        $body['SubscriptionId'] = $subscription->id;
                        $body['LicenseSubscriptionType'] = $subscription->plan->name;
                        $body['Status'] = 'active';
                        $body['PurchaseDate'] = $subscription->start_date->format('Y-m-d H:i:s');
                        $body['ExpirationDate'] = $subscription->end_date->format('Y-m-d H:i:s');
                        $body['OrderCurrency'] = $stripe_subscription->items->data[0]->price->currency ?? 'eur'; // TODO: This is different when multiplan is enabled
                        $body['Price'] = $stripe_subscription->items->data[0]->price->unit_amount / 100; // TODO: This is different when multiplan is enabled
                        $body['Tax'] = 21; // TODO: Make this respect Stripe tax!
                    // }

                    $response = Http::post($is_trial ? $route_trial : $route_paid, $body);
                    // die(print_r($response->body()));
                    $response_json = $response->json();

                    if(empty($response_json['status'] ?? null) || $response_json['status'] !== 'success') {
                        // If status is not success for any reason, throw an error
                        http_response_code(400);
                        Log::error(pix_pro_error($is_trial ? $route_trial : $route_paid, 'There was an error while trying to create a license(order) in pix-pro API DB, check the response below.', $response_json));
                    } else {

                        if(!empty($response_json['data'] ?? null)) {
                            // If licenses are correctly added, fetch them with pix_pro_get_user_licenses() and crete them on our end...
                            $pix_license = $response_json['data'];

                            DB::beginTransaction();

                            try {
                                $license = new License();
                                $license->license_name = $pix_license['license_name'] ?? '';
                                $license->serial_number = $pix_license['serial_number'] ?? '';
                                $license->license_type = $pix_license['license_type'] ?? '';
                                $license->data = $pix_license; // Will be populaetd when user activates the license
                                $license->save();

                                // Add a license <-> user_subscription relationship
                                DB::table('user_subscription_relationships')->updateOrInsert(
                                    ['user_subscription_id' => $subscription->id, 'subject_id' => $license->id, 'subject_type' => $license::class],
                                    ['created_at' => date('Y:m:d H:i:s'), 'updated_at' => date('Y:m:d H:i:s')]
                                );

                                DB::commit();
                            } catch(\Throwable $e) {
                                DB::rollback();
                                http_response_code(400);
                                print_r($e);
                                Log::error(pix_pro_error($is_trial ? $route_trial : $route_paid, 'There was an error while trying to create a license on WeSaaS end and link it to user_subscription.', $e));

                                die();
                            }

                        }
                    }

                } else {
                    Log::error(pix_pro_error($is_trial ? $route_trial : $route_paid, 'There was an error while trying to create a license(order) in pix-pro API DB, Could not get the user y email from pix-pro api', ''));
                }
            }
        }
    }
}

// UPDATE LICENSE
if (!function_exists('pix_pro_update_license')) {
    function pix_pro_update_license($user_subscriptions) {
        $route_paid = pix_pro_endpoint().'/paid/update_license_settings/';
        
        if ($user_subscriptions->isNotEmpty()) {
            foreach($user_subscriptions as $subscription) {

                $stripe_subscription_id = $subscription->data[StripeService::getStripeMode().'stripe_subscription_id'];

                $stripe_subscription = StripeService::stripe()->subscriptions->retrieve(
                    $stripe_subscription_id,
                    []
                  );

                $is_trial = !empty($stripe_subscription->trial_start ?? null) && !empty($stripe_subscription->trial_end ?? null);

                $pix_pro_user = pix_pro_get_user($subscription->user)['data'] ?? [];

                if(!empty($pix_pro_user['user_id'] ?? null)) {
                    $number_of_images = $subscription->subject->getCoreMeta('number_of_images');
                    
                    if(!empty($number_of_images) && (is_int($number_of_images) || ctype_digit($number_of_images))) {
                        $number_of_images = $subscription->subject->getCoreMeta('number_of_images') ?? 150;
                    } else {
                        $number_of_images = 150;
                    }

                    $body = pix_pro_add_auth_params([
                        "UserEmail" => $pix_pro_user['email'],
                        "UserPassword" => $subscription->user->getCoreMeta('password_md5'),
                        "SubscriptionId" => $subscription->id,
                        "LicenseName" => $subscription->plan->name,
                        "LicenseCloudService" => $subscription->subject->getCoreMeta('includes_cloud') === true ? 1 : 0,
                        "LicenseOfflineService" => $subscription->subject->getCoreMeta('includes_offline') === true ? 1 : 0,
                        "LicenseImageLimit" => $number_of_images,
                    ]);

                    $response = Http::post($route_paid, $body);

                    $response_json = $response->json();
                    
                    if(empty($response_json['status'] ?? null) || $response_json['status'] !== 'success') {
                        // If status is not success for any reason, throw an error
                        http_response_code(400);
                        Log::error(pix_pro_error($route_paid, 'There was an error while trying to update a license(order) in pix-pro API DB, check the response below.', $response_json));
                    } else {

                        if(!empty($response_json['license'] ?? null)) {
                            // If licenses are correctly added, fetch them with pix_pro_get_user_licenses() and crete them on our end...
                            $pix_license = $response_json['license'];

                            DB::beginTransaction();

                            try {
                                $license = $subscription->license->first();
                                $license->license_name = $pix_license['license_name'] ?? '';
                                // $license->serial_number = $pix_license['serial_number'] ?? '';
                                $license->license_type = $pix_license['license_type'] ?? '';
                                $license->data = $pix_license; // Will be populaetd when user activates the license
                                $license->save();

                                // Change subscription default attributes based on new plan
                                $subscription->saveCoreMeta('number_of_images', $number_of_images);
                                $subscription->saveCoreMeta('includes_cloud', $subscription->subject->getCoreMeta('includes_cloud'));
                                $subscription->saveCoreMeta('includes_offline', $subscription->subject->getCoreMeta('includes_offline'));

                                DB::commit();
                            } catch(\Throwable $e) {
                                DB::rollback();
                                http_response_code(400);
                                print_r($e);
                                Log::error(pix_pro_error($route_paid, 'There was an error while trying to update a license on WeSaaS end and link it to user_subscription.', $e));

                                die();
                            }

                        }
                    }
                } else {
                    Log::error(pix_pro_error($route_paid, 'There was an error while trying to update a license(order) in pix-pro API DB, Could not get the user by email from pix-pro api', ''));
                }
            }
        }
    }
}

// EXTEND LICENSE
if (!function_exists('pix_pro_extend_license')) {
    function pix_pro_extend_license($user_subscriptions, $stripe_invoice) {
        $route_trial = pix_pro_endpoint().'/paid/renew_licenses/';
        $route_paid = pix_pro_endpoint().'/paid/renew_licenses/';

        if ($user_subscriptions->isNotEmpty()) {
            foreach($user_subscriptions as $subscription) {

                $stripe_subscription_id = $subscription->data[StripeService::getStripeMode().'stripe_subscription_id'];

                $stripe_subscription = StripeService::stripe()->subscriptions->retrieve(
                    $stripe_subscription_id,
                    []
                  );

                $is_trial = !empty($stripe_subscription->trial_start ?? null) && !empty($stripe_subscription->trial_end ?? null);

                $pix_pro_user = pix_pro_get_user($subscription->user)['data'] ?? [];

                if(!empty($pix_pro_user['user_id'] ?? null)) {
                    $body = pix_pro_add_auth_params([
                        "UserEmail" => $pix_pro_user['email'],
                        "UserPassword" => $subscription->user->getCoreMeta('password_md5'),
                        "LicenseImageLimit" => $subscription->getCoreMeta('number_of_images'),
                    ]);

//                     // if(!$is_trial) {
//                         // If license is not trial, append more params
                        $body['SubscriptionId'] = $subscription->id;
                        $body['NewStatus'] = 'active';
                        $body['PurchaseDate'] = date('Y-m-d H:i:s', $subscription->start_date);
                        $body['ExpirationDate'] = date('Y-m-d H:i:s', $subscription->end_date);
                        $body['OrderCurrency'] = $stripe_subscription->items->data[0]->price->currency ?? 'eur'; // TODO: This is different when multiplan is enabled
                        $body['Price'] = $stripe_subscription->items->data[0]->price->unit_amount / 100; // TODO: This is different when multiplan is enabled
                        $body['Tax'] = 21; // TODO: Make this respect Stripe tax!
//                     // }

                    $response = Http::post($is_trial ? $route_trial : $route_paid, $body);

                    $response_json = $response->json();

                    if(empty($response_json['status'] ?? null) || $response_json['status'] !== 'success') {
                        // If status is not success for any reason, throw an error
                        Log::error(pix_pro_error($is_trial ? $route_trial : $route_paid, 'There was an error while trying to EXTEND a license(order) in pix-pro API DB. check the response below.', $response_json));
                    } else {
                        // If everything is ok...should we add anything else???
                    }

                } else {
                    Log::error(pix_pro_error($is_trial ? $route_trial : $route_paid, 'There was an error while trying to EXTEND a license(order) in pix-pro API DB. Could not get the user by email from pix-pro api', ''));
                }
            }
        }
    }
}

if (!function_exists('pix_pro_get_license_by_serial_number')) {
    function pix_pro_get_license_by_serial_number($license) {
        if(empty($license)) {
            return false;
        }
        $route = pix_pro_endpoint().'/licenses/get_license_by_serial_number/';
        $user = $license->user_subscription->first()->user;

        $body = pix_pro_add_auth_params([
            "UserPassword" => $user->getCoreMeta('password_md5', true),
            "UserEmail" => $user->email,
            "UserSn" => $license->serial_number,
        ]);

        $response = Http::post($route, $body);
        $response_json = $response->json();

        if(!empty($response_json['status'] ?? null)) {
            // If status is not success for any reason, throw an error
            if($response_json['status'] !== 'success') {
                Log::error(pix_pro_error($route, 'There was an error while trying to get license by following serial number: '.$license->serial_number, $response_json));
            }

            return $response_json;
        }

        return null;
    }
}

if (!function_exists('pix_pro_get_user')) {
    function pix_pro_get_user($user) {
        $route = pix_pro_endpoint().'/users/get_user_by_email/';

        $body = [
            "UserEmail" => $user->email
        ];

        $response = Http::post($route, $body);
        $response_json = $response->json();

        if(!empty($response_json['status'] ?? null)) {
            // If status is not success for any reason, throw an error
            if($response_json['status'] !== 'success') {
                if(pix_pro_register_user($user)) {
                    return pix_pro_get_user($user);
                }
                // Log::error(pix_pro_error($route, 'There was an error while trying to get a user', $response_json));
            }
        }

        return $response_json;
    }
}

if (!function_exists('pix_pro_get_user_licenses')) {
    function pix_pro_get_user_licenses($user) {
        $response_json = pix_pro_get_user($user);

        if(!empty($response_json['status'] ?? null)) {
            if(!empty($pix_user['data'])) {

            }

            // If status is not success for any reason, throw an error
            if($response_json['status'] !== 'success') {
                Log::error(pix_pro_error($route, 'There was an error while trying to get a user', $response_json));
            }
        }

        // return $response_json;
    }
}

if (!function_exists('pix_pro_update_user_password')) {
    function pix_pro_update_user_password($user, $newPassword, $oldPassword) {
        $route = pix_pro_endpoint().'/users/update_user_password/';

        $body = pix_pro_add_auth_params([
            "UserEmail" => $user->email,
            "UserPassword" => $oldPassword['wp_md5'],
            "UserNewPassword" => $newPassword['wp_md5'],
        ]);

        $response = Http::post($route, $body);
        $response_json = $response->json();

        if(!empty($response_json['status'] ?? null)) {
            // If status is not success for any reason, throw an error
            if($response_json['status'] !== 'success') {
                Log::error(pix_pro_error($route, 'There was an error while trying to change password.', $response_json));
                return false;
            } else {
                return true;
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
if (!function_exists('pix_pro_add_auth_params')) {
    function pix_pro_add_auth_params($params) {
        return array_merge([
            'name' =>  get_tenant_setting('pix_pro_api_username'),
            'pass' => get_tenant_setting('pix_pro_api_password'),
        ], $params);
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
