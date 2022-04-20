<?php

namespace App\Http\Controllers;

use App\Facades\TenantSettings;
use App\Models\Currency;
use App\Models\TenantSetting;
use Artisan;
use Cache;
use CoreComponentRepository;
use Illuminate\Http\Request;

// TODO: REMOVE ALL .env CHANGES IN THIS CONTROLLER AND MOVE THOSE CHANGES TO DB!!!!
class TenantSettingsController extends Controller
{
    public function general_setting(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.general_settings');
    }

    public function checkout_flow(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.checkout_flow');
    }

    public function activation(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.activation');
    }

    public function social_login(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.social_login');
    }

    public function smtp_settings(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.smtp_settings');
    }

    public function google_analytics(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.google_analytics');
    }

    public function google_recaptcha(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.google_recaptcha');
    }

    public function facebook_chat(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.facebook_chat');
    }

    public function facebook_comment(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.facebook_configuration.facebook_comment');
    }

    public function payment_method(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.payment_method');
    }

    public function file_system(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.file_system');
    }

    /**
     * Update the API key's for payment methods.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_method_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $tenant_settings = TenantSetting::getModel($request->payment_method.'_sandbox');
        $tenant_settings->value = $request->has($request->payment_method.'_sandbox') ? 1 : 0;
        $tenant_settings->save();

        flash(translate('Settings updated successfully'))->success();

        return back();
    }

    /**
     * Update the API key's for GOOGLE analytics.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function google_analytics_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $tenant_settings = TenantSetting::getModel('google_analytics');
        $tenant_settings->value = $request->has('google_analytics') ? 1 : 0;
        $tenant_settings->save();

        flash(translate('Settings updated successfully'))->success();

        return back();
    }

    public function google_recaptcha_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $tenant_settings = TenantSetting::getModel('google_recaptcha');
        $tenant_settings->value = $request->has('google_recaptcha') ? 1 : 0;
        $tenant_settings->save();

        flash(translate('Settings updated successfully'))->success();

        return back();
    }

    /**
     * Update the API key's for GOOGLE analytics.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function facebook_chat_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $tenant_settings = TenantSetting::getModel('facebook_chat');
        $tenant_settings->value = $request->has('facebook_chat') ? 1 : 0;
        $tenant_settings->save();

        flash(translate('Settings updated successfully'))->success();

        return back();
    }

    public function facebook_comment_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $tenant_settings = TenantSetting::getModel('facebook_comment');
        $tenant_settings->value = $request->has('facebook_comment') ? 1 : 0;
        $tenant_settings->save();

        flash(translate('Settings updated successfully'))->success();

        return back();
    }

    public function facebook_pixel_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $tenant_settings = TenantSetting::getModel('facebook_pixel');
        $tenant_settings->value = $request->has('facebook_pixel') ? 1 : 0;
        $tenant_settings->save();

        flash(translate('Settings updated successfully'))->success();

        return back();
    }

    /**
     * Update the API key's for other methods.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function env_key_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        flash(translate('Settings updated successfully'))->success();

        return back();
    }

    /**
     * overWrite the Env File values.
     * @param  string type
     * @param  string value
     * @return \Illuminate\Http\Response
     */
    public function overWriteEnvFile($type, $val)
    {
        // TODO: FIX THIS!
        if (env('DEMO_MODE') != 'On') {
            $path = base_path('.env');
            if (file_exists($path)) {
                $val = '"'.trim($val).'"';
                if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
                    file_put_contents($path, str_replace(
                        $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                    ));
                } else {
                    file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
                }
            }
        }
    }

    public function seller_verification_form(Request $request)
    {
        return view('backend.sellers.seller_verification_form.index');
    }

    /**
     * Update sell verification form.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function seller_verification_form_update(Request $request)
    {
        $form = [];
        $select_types = ['select', 'multi_select', 'radio'];
        $j = 0;
        for ($i = 0; $i < count($request->type); $i++) {
            $item['type'] = $request->type[$i];
            $item['label'] = $request->label[$i];
            if (in_array($request->type[$i], $select_types)) {
                $item['options'] = json_encode($request['options_'.$request->option[$j]]);
                $j++;
            }
            array_push($form, $item);
        }
        $tenant_settings = TenantSetting::getModel('verification_form');
        $tenant_settings->value = json_encode($form);
        if ($tenant_settings->save()) {
            flash(translate('Verification form updated successfully'))->success();

            return back();
        }
    }

    public function update(Request $request)
    {
        foreach ($request->types as $key => $setting) {
            if ($setting == 'site_name') {
                $this->overWriteEnvFile('APP_NAME', $request[$setting]);
            }
            if ($setting == 'timezone') {
                $this->overWriteEnvFile('APP_TIMEZONE', $request[$setting]);
            } else {
                $value = is_array($request[$setting]) ? json_encode($request[$setting]) : $request[$setting];

                $tenant_setting = TenantSetting::getModel($setting);
                $tenant_setting->setting = $setting;
                $tenant_setting->value = $value;

                // Save setting to primary DB
                $tenant_setting->save();
            }
        }
        flash(translate('Settings updated successfully'))->success();

        return back();
    }

    public function get($setting)
    {
        if (empty($setting)) {
            return null;
        }
    }

    public function updateActivationSettings(Request $request)
    {
        $env_changes = ['FORCE_HTTPS', 'FILESYSTEM_DRIVER'];
        if (in_array($request->type, $env_changes)) {
            return $this->updateActivationSettingsInEnv($request);
        }

        $tenant_setting = TenantSetting::getModel($request->type);

        /* TODO: MOVE MAINTANANCE MODE TO BE DETERMINED only from DB*/
        if ($request->type == 'maintenance_mode' && $request->value == '1') {
            if (env('DEMO_MODE') != 'On') {
                Artisan::call('down');
            }
        } elseif ($request->type == 'maintenance_mode' && $request->value == '0') {
            if (env('DEMO_MODE') != 'On') {
                Artisan::call('up');
            }
        }

        $tenant_setting->value = $request->value;
        $tenant_setting->save();

        return '1';
    }

    public function updateActivationSettingsInEnv($request)
    {
        if ($request->type == 'FORCE_HTTPS' && $request->value == '1') {
            $this->overWriteEnvFile($request->type, 'On');

            if (strpos(env('APP_URL'), 'http:') !== false) {
                $this->overWriteEnvFile('APP_URL', str_replace('http:', 'https:', env('APP_URL')));
            }
        } elseif ($request->type == 'FORCE_HTTPS' && $request->value == '0') {
            $this->overWriteEnvFile($request->type, 'Off');
            if (strpos(env('APP_URL'), 'https:') !== false) {
                $this->overWriteEnvFile('APP_URL', str_replace('https:', 'http:', env('APP_URL')));
            }
        } elseif ($request->type == 'FILESYSTEM_DRIVER' && $request->value == '1') {
            $this->overWriteEnvFile($request->type, 's3');
        } elseif ($request->type == 'FILESYSTEM_DRIVER' && $request->value == '0') {
            $this->overWriteEnvFile($request->type, 'local');
        }

        return '1';
    }

    public function vendor_commission(Request $request)
    {
        $tenant_settings = get_setting('vendor_commission');

        return view('backend.sellers.seller_commission.index', compact('tenant_settings'));
    }

    public function vendor_commission_update(Request $request)
    {
        $tenant_settings = TenantSetting::getModel($request->type);
        $tenant_settings->value = $request->value;
        $tenant_settings->save();

        flash(translate('Seller Commission updated successfully'))->success();

        return back();
    }

    public function shipping_configuration(Request $request)
    {
        return view('backend.setup_configurations.shipping_configuration.index');
    }

    public function shipping_configuration_update(Request $request)
    {
        $tenant_settings = TenantSetting::getModel($request->type);
        $tenant_settings->value = $request[$request->type];
        $tenant_settings->save();

        return back();
    }

    public function seo_setting()
    {
        return view('backend.seo.index');
    }

    public function update_seo_setting(Request $request)
    {
        foreach ($request->types as $key => $setting) {
            $tenant_settings = TenantSetting::getModel($setting);
            $tenant_settings->value = $request[$setting];
            $tenant_settings->save();
        }
        flash(translate('SEO Settings updated successfully'))->success();

        return back();
    }
}
