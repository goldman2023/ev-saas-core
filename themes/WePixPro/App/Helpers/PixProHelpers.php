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
                Log::error(pix_pro_error($route, 'There was an error while trying to activate desired license.', $response_json));

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
        }
    }
}

if (!function_exists('pix_pro_disconnect_license')) {
    function pix_pro_disconnect_license($license, $user, $form = null) {
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
                    $license->setData('hardware_id', null);
                    $license->save();

                    if(!empty($form)) {
                        $form->inform(translate('You successfully disconnected your license!'), translate('Serial number: ').$license->serial_number, 'success');
                    }

                    return $response_json;
                }
            }

            if(!empty($form)) {
                $form->inform(translate('Error: Cannot disconnect license from hardware...'), translate('Serial number: ').$license->serial_number, 'fail');
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            // dd($e);
        }
    }
}


// CREATE LICENSE
if (!function_exists('pix_pro_create_license')) {
    function pix_pro_create_license($subscription, $stripe_invoice) {
        $route_paid = pix_pro_endpoint().'/paid/add_license/';

        if (!empty($subscription)) {
            $stripe_subscription_id = $subscription->data[StripeService::getStripeMode().'stripe_subscription_id'];

            $stripe_subscription = StripeService::stripe()->subscriptions->retrieve(
                $stripe_subscription_id,
                []
            );

            $is_trial = $stripe_subscription->status === 'trialing';

            $pix_pro_user = pix_pro_get_user($subscription->user)['data'] ?? [];

            if(!empty($pix_pro_user['user_id'] ?? null)) {
                foreach($subscription->items as $plan) {
                    // Create X amount of licenses based on pivot table qty column (if there's only one $plan and qty 1, then only one license will be created)
                    for ($i = 1; $i <= $plan->pivot->qty; $i++) {
                        $stripe_item = collect($stripe_subscription->items->data)->firstWhere('price.product', $plan->getCoreMeta(StripeService::getStripeMode().'stripe_product_id'));

                        $number_of_images = $plan->getCoreMeta('number_of_images');

                        if(!empty($number_of_images) && (is_int($number_of_images || ctype_digit($number_of_images)))) {
                            $number_of_images = $plan->getCoreMeta('number_of_images') ?? 150;
                        } else {
                            $number_of_images = 150;
                        }

                        $cloud_service_param = $plan->getCoreMeta('includes_cloud') === true ? 1 : 0;
                        $offline_service_param = $plan->getCoreMeta('includes_offline') === true ? 1 : 0;
                        $license_subscription_type = $plan->name.'_'.$cloud_service_param.'_'.$offline_service_param.'_'.$number_of_images;

                        $body = pix_pro_add_auth_params([
                            "UserEmail" => $pix_pro_user['email'],
                            "UserPassword" => $subscription->user->getCoreMeta('password_md5'),
                            "Qty" => 1, // THIS IS NUMBER OF TRIAL LICENSES TO BE CREATED! - WE SHOULD ALWAYS PUT 1, since we loop it on our end!
                            "LicenseType" => 'full', // TODO: Can be `manual` too
                            "LicenseCloudService" => $cloud_service_param,
                            "LicenseOfflineService" => $offline_service_param,
                            "LicenseImageLimit" => $number_of_images,
                            "PackageTypes" => 'mining',
                            "SubscriptionId" => $subscription->id,
                            "LicenseSubscriptionType" => $license_subscription_type,
                            "Status" => 'active',
                            "Tax" => 21, // TODO: Make this respect Stripe tax!
                            "PurchaseDate" => $subscription->start_date->format('Y-m-d H:i:s'),
                            "ExpirationDate" => $subscription->end_date->format('Y-m-d H:i:s'),
                            "OrderCurrency" => $stripe_item?->price?->currency ?? 'eur',
                            "Price" => ($stripe_item?->price?->unit_amount / 100) ?? $plan->getTotalPrice(),
                        ]);
        
                        $response = Http::post($route_paid, $body);
                        $response_json = $response->json();
        
                        if(empty($response_json['status'] ?? null) || $response_json['status'] !== 'success') {
                            // If status is not success for any reason, throw an error
                            http_response_code(400);
                            Log::error(pix_pro_error($route_paid, 'There was an error while trying to create a license(order) in pix-pro API DB, check the response below.', $response_json));
                        } else {
                            if(!empty($response_json['license'] ?? null)) {
                                $pix_license = $response_json['license'];
        
                                DB::beginTransaction();
        
                                try {
                                    $license = new License();
                                    $license->user_id = $subscription->user->id;
                                    $license->license_name = $pix_license['license_name'] ?? '';
                                    $license->serial_number = $pix_license['serial_number'] ?? '';
                                    $license->license_type = $pix_license['license_type'] ?? '';
        
                                    $data = empty($license->data) ? [] : $license->data;
                                    $license->data = array_merge($data, $pix_license); // Will be populated when user activates the license
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
                                    Log::error(pix_pro_error($route_paid, 'There was an error while trying to create a license on WeSaaS end and link it to user_subscription.', $e));
        
                                    die();
                                }
        
                            }
                        }

                    }
                }
            } else {
                Log::error(pix_pro_error($route_paid, 'There was an error while trying to create a license(order) in pix-pro API DB, Could not get the user y email from pix-pro api', ''));
            }
        }
    }
}

// UPDATE LICENSE
if (!function_exists('pix_pro_update_license')) {
    function pix_pro_update_license($subscription, $stripe_invoice, $stripe_previous_attributes) {
        $route_paid = pix_pro_endpoint().'/paid/update_license_settings/';
        
        if (!empty($subscription)) {
            $stripe_billing_reason = $stripe_invoice->billing_reason;

            $stripe_subscription_id = $subscription->data[StripeService::getStripeMode().'stripe_subscription_id'];

            $stripe_subscription = StripeService::stripe()->subscriptions->retrieve(
                $stripe_subscription_id,
                []
            );

            $is_trial = !empty($stripe_subscription->trial_start ?? null) && !empty($stripe_subscription->trial_end ?? null);

            $pix_pro_user = pix_pro_get_user($subscription->user)['data'] ?? [];


            if(($stripe_billing_reason === 'subscription_update' || $stripe_billing_reason === 'subscription_create') && !empty($stripe_previous_attributes?->plan?->id ?? null)) {
                // If the billing_reason is subscription_update or subscription_create WHILE previous_attributes plan change are present:
                // Compare differences in bought licenses and their quantities and based on that create more licenses if needed.
                
            }

            if(!empty($pix_pro_user['user_id'] ?? null)) {
                $number_of_images = $subscription->subject->getCoreMeta('number_of_images'); // get default meta from Plan, not previous subscription!
                
                if(!empty($number_of_images) && (is_int($number_of_images) || ctype_digit($number_of_images))) {
                    $number_of_images = $subscription->subject->getCoreMeta('number_of_images') ?? 150; // get default meta from Plan, not previous subscription!
                } else {
                    $number_of_images = 150;
                }

                $cloud_service_param = $subscription->subject->getCoreMeta('includes_cloud') === true ? 1 : 0;
                $offline_service_param = $subscription->subject->getCoreMeta('includes_offline') === true ? 1 : 0;
                $license_subscription_type = $subscription->plan->name.'_'.$cloud_service_param.'_'.$offline_service_param.'_'.$number_of_images;

                $body = pix_pro_add_auth_params([
                    "UserEmail" => $pix_pro_user['email'],
                    "UserPassword" => $subscription->user->getCoreMeta('password_md5'),
                    "SubscriptionId" => $subscription->id,
                    "LicenseName" => $license_subscription_type, // This is actually `license_subscription_type` column in PixPro DB
                    "LicenseCloudService" => $cloud_service_param,
                    "LicenseOfflineService" => $offline_service_param,
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
                            $license->user_id = $subscription->user->id;
                            $license->license_name = $pix_license['license_name'] ?? '';
                            // $license->serial_number = $pix_license['serial_number'] ?? '';
                            $license->license_type = $pix_license['license_type'] ?? '';
                            
                            $license->mergeData($pix_license); // Keep in mind that expiration date is NOT YET CHANGED ON PixPro end, because this endpoint doesn't set it. We'll update each subscription expiration_date in following function: `$this->pix_pro_update_licenses_status($subscription);`
                            $license->save();

                            // Change subscription default attributes based on a new selected Plan
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

            // Update licenses statuses AND expiration_date(s) by looping through subscription licenses
            pix_pro_update_licenses_status($subscription);
        }
    }
}

// UPDATE SINGLE LICENSE
if (!function_exists('pix_pro_update_single_license')) {
    function pix_pro_update_single_license(&$license, $old_license) {
        $route_paid = pix_pro_endpoint().'/paid/update_license_settings/';
        
        $subscription = $license->user_subscription->first();

        $pix_pro_user = pix_pro_get_user($subscription->user)['data'] ?? [];

        if(!empty($pix_pro_user['user_id'] ?? null)) {
            $number_of_images = $license->getData('license_image_limit');

            if(!empty($number_of_images) && (is_int($number_of_images) || ctype_digit($number_of_images))) {
                $number_of_images = $license->getData('license_image_limit');
            } else {
                $number_of_images = 150;
            }

            $cloud_service_param = $license->getData('cloud_service');
            $offline_service_param = $license->getData('offline_service');
            $license_subscription_type = $subscription->plan->name.'_'.$cloud_service_param.'_'.$offline_service_param.'_'.$number_of_images;

            $body = pix_pro_add_auth_params([
                "UserEmail" => $pix_pro_user['email'],
                "UserPassword" => $subscription->user->getCoreMeta('password_md5'),
                "LicenseId" => $license->getData('id') ?? '',
                "SubscriptionId" => $subscription->id,
                "LicenseName" => $license_subscription_type, // This is actually `license_subscription_type` column in PixPro DB
                "LicenseCloudService" => $cloud_service_param,
                "LicenseOfflineService" => $offline_service_param,
                "LicenseImageLimit" => $number_of_images,
            ]);

            $response = Http::post($route_paid, $body);

            $response_json = $response->json();

            if(empty($response_json['status'] ?? null) || $response_json['status'] !== 'success') {
                // If status is not success for any reason, throw an error
                http_response_code(400);
                Log::error(pix_pro_error($route_paid, 'Function: pix_pro_update_single_license(). There was an error while trying to update a license(order) in pix-pro API DB, check the response below.', $response_json));
            } else {
                if(!empty($response_json['license'] ?? null)) {
                    $pix_license = $response_json['license'];

                    $license->setData('license_subscription_type', $pix_license['license_subscription_type'] ?? null, null);
                    $license->save();

                    $license->saveCoreMeta('number_of_images', $number_of_images);
                    $license->saveCoreMeta('includes_cloud', $cloud_service_param);
                    $license->saveCoreMeta('includes_offline', $offline_service_param);

                    // If hardware_id is changed on our end, change it on pixpro end too (by activating license)
                    // 1. Hardware ID was not present in license data -> activate license
                    // 2. Hardware ID was present in license data -> disconnect and then activate with new hardware_id

                    if(!empty($license->getData('hardware_id'))) {
                        // There was a hardware_id before, and new hardware_id is different than before -> deactive license first
                        if(!empty($pix_license['hardware_id'] ?? null) && $license->getData('hardware_id') != $pix_license['hardware_id']) {
                            pix_pro_disconnect_license($old_license, $subscription->user);
                        }

                        // Just activate license now
                        $activation_response = pix_pro_activate_license($subscription->user, $license->serial_number, $license->getData('hardware_id'));
                            
                        $new_license_file = $activation_response['license_file'] ?? null;

                        if(!empty($new_license_file)) {
                            if(!empty($new_license_file['file_name'] ?? null) && !empty($new_license_file['file_contents'] ?? null)) {
                                $license->setData('file_name', $new_license_file['file_name']);
                                $license->setData('file_contents', $new_license_file['file_contents']);
                                $license->save();
                            }
                        }
                    }
                    
                }
            }
        } else {
            Log::error(pix_pro_error($route_paid, 'Function: pix_pro_update_single_license(). There was an error while trying to save a single license(order) in Pixpro API DB. Could not get the user by email from Pixpro api', ''));
        }
    }
}

// UPDATE LICENSE STATUS
if (!function_exists('pix_pro_update_licenses_status')) {
    function pix_pro_update_licenses_status($subscription) {
        $route_paid = pix_pro_endpoint().'/paid/update_license_status/';
        
        if (!empty($subscription)) {
            $stripe_subscription_id = $subscription->data[StripeService::getStripeMode().'stripe_subscription_id'];

            $stripe_subscription = StripeService::stripe()->subscriptions->retrieve(
                $stripe_subscription_id,
                []
            );

            $is_trial = $stripe_subscription->status === 'trialing';

            $pix_pro_user = pix_pro_get_user($subscription->user)['data'] ?? [];
            
            if(!empty($pix_pro_user['user_id'] ?? null)) {
                foreach($subscription->licenses as $license) {
                    $body = pix_pro_add_auth_params([
                        "UserEmail" => $pix_pro_user['email'],
                        "UserPassword" => $subscription->user->getCoreMeta('password_md5'),
                        "LicenseId" => $license->getData('id'),
                        "SubscriptionId" => $subscription->id,
                        "ExpirationDate" => $subscription->end_date->format('Y-m-d H:i:s'),
                        "NewStatus" => in_array($subscription->status, ['active', 'active_until_end', 'trial']) ? 'active' : 'cancelled',
                    ]);
                    $response = Http::post($route_paid, $body);
                    $response_json = $response->json();

                    if(empty($response_json['status'] ?? null) || $response_json['status'] !== 'success') {
                        // If status is not success for any reason, throw an error
                        http_response_code(400);
                        Log::error(pix_pro_error($route_paid, 'There was an error while trying to update license status and expiration date in pix-pro API DB, check the response below.', $response_json));
                    } else {
                        if(!empty($response_json['license'] ?? null)) {
                            $pix_license = $response_json['license'];
    
                            DB::beginTransaction();
    
                            try {
                                $license->user_id = $subscription->user->id;
                                $license->mergeData($pix_license);
                                $license->save();
    
                                DB::commit();
                            } catch(\Throwable $e) {
                                DB::rollback();
                                http_response_code(400);
                                print_r($e);
                                Log::error(pix_pro_error($route_paid, 'There was an error while trying to update a license on WeSaaS (after status and expiration_date are updated on PixPro end)', $e));
    
                                die();
                            }
                        }
                    }
                }
            } else {
                Log::error(pix_pro_error($route_paid, 'There was an error while trying to update a license(order) in Pixpro API DB. Could not get the user by email from Pixpro api', ''));
            }
            
        }
    }
}


// EXTEND LICENSE
if (!function_exists('pix_pro_extend_licenses')) {
    function pix_pro_extend_licenses($subscription, $stripe_invoice) {
        $route_paid = pix_pro_endpoint().'/paid/renew_licenses/';

        if (!empty($subscription)) {
            $stripe_subscription_id = $subscription->data[StripeService::getStripeMode().'stripe_subscription_id'];

            $stripe_subscription = StripeService::stripe()->subscriptions->retrieve(
                $stripe_subscription_id,
                []
            );

            $is_trial = $stripe_subscription->status === 'trialing';

            $pix_pro_user = pix_pro_get_user($subscription->user)['data'] ?? [];

            if(!empty($pix_pro_user['user_id'] ?? null)) {
                $body = pix_pro_add_auth_params([
                    "UserEmail" => $pix_pro_user['email'],
                    "UserPassword" => $subscription->user->getCoreMeta('password_md5'),
                    "SubscriptionId" => $subscription->id,
                    "NewStatus" => 'active',
                    "PurchaseDate" => $subscription->start_date->format('Y-m-d H:i:s'),
                    "ExpirationDate" => $subscription->end_date->format('Y-m-d H:i:s'),
                    "basic_renew" => 'yes' // This will skip updating: license_image_limit, order_currency, price, tax; in Pixpro DB. Reason is that these settings are variable per license and pixpro updates all licenses with same subscription_id in bulk manner in renew_licenses function!
                ]);
                
                $response = Http::post($route_paid, $body);

                $response_json = $response->json();

                if(empty($response_json['status'] ?? null) || $response_json['status'] !== 'success') {
                    // If status is not success for any reason, throw an error
                    Log::error(pix_pro_error($route_paid, 'There was an error while trying to EXTEND a license(order) in pix-pro API DB. check the response below.', $response_json));
                } else {
                    $pix_licenses = $response_json['licenses'] ?? null;

                    if(!empty($pix_licenses)) {
                        foreach($pix_licenses as $pix_license) {
                            $license = $subscription->licenses->firstWhere('data.id', $pix_license['id']);
                            $license->user_id = $subscription->user->id;
                            $license->mergeData($pix_license);
                            $license->save();
                        }
                    }
                }
            } else {
                Log::error(pix_pro_error($route_paid, 'There was an error while trying to EXTEND a license(order) in pix-pro API DB. Could not get the user by email from pix-pro api', ''));
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
