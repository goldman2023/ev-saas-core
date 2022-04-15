<?php

namespace App\Http\Controllers;

use App\Http\Services\PermissionsService;
use App\Models\Shop;
use Illuminate\Http\Request;
use Permissions;

class OnboardingController extends Controller
{
    //
    public function welcome()
    {
        return view('frontend.onboarding.welcome');
    }

    public function step2()
    {
        return view('frontend.onboarding.step2');
    }

    public function profile_store()
    {

        return redirect()->route('onboarding.step4');
    }

    public function step3()
    {
        $user = auth()->user();
        if ($user->user_type == 'customer') {
            $user->user_type = 'seller';
            $user->save();
        }

        if ($user->shop()->count() > 0) {
            $shop = $user->shop()->first();
        } else {
            $shop = new Shop();
            $shop->name = 'Your Shop';
        }



        /* @vukasin TODO: Replace this with new way of adding address */
        // $shop->address = $request->address;

        if ($shop->save()) {
            $shop->users()->sync($user); // Use sync instead of attach, otherwise there will be multiple records of reationships between same user and shop
            $permissions = Permissions::getRolePermissions('Owner');

            /* TODO:  Move this to a general app layer to check if permisisons is missing, if so, run permissions populate */
            try {
                $user->syncPermissions($permissions);
                $user->syncRoles(['Owner']);
            } catch (\Exception $e) {
                \Artisan::call('tenants:migrate --tenants=' . tenant()->id);
                \Artisan::call('tenants:seed --tenants=' . tenant()->id);
                \Artisan::call('permissions:populate --tenant_id=' . tenant()->id);
                $user->syncPermissions($permissions);
                $user->syncRoles(['Owner']);
            }


            if (get_setting('email_verification') != 1) {

                // Notification::send(User::where('id', '!=', $user->id)->get(), new NewCompanyJoin($user));
            } else {
                // $user->notify(new EmailVerificationNotification());
            }

            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();

            flash(translate('Your Company has been created successfully!'))->success();
        }

        return view('frontend.onboarding.step3');
    }


    public function step4()
    {
        return view('frontend.onboarding.step4');
    }

    public function verification()
    {
        return view('frontend.onboarding.verification');
    }
}
