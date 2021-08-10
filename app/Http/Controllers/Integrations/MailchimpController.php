<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Newsletter\NewsletterFacade as Newsletter;


class MailchimpController extends Controller
{
    //


    public function subscribe(Request $request, $type)
    {
        $email = $request->input('email');

        $first_name = $request->input('name');
        $last_name = $request->input('name');
        $data = Newsletter::subscribe($email, ['FNAME' => $first_name, 'LNAME' => $last_name]);

        if ($data === false) {
            $error = Newsletter::getLastError();
            flash(($error));
            return redirect()->back();
        } else {
            flash(translate('Thank you! Please check your emails about early-bird campaign details. '));
            return redirect()->back();
        }
    }
}
