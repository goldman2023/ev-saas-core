<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'company_name' => 'required|string|min:1',
            'address' => 'required|string|min:1',
            'country' => 'required|string|min:1',
            'name' => 'required|string|min:1',
            'email' => 'required|string|min:1|email|unique:users,email',
            'phone_number' => 'required|string|min:1',
            'password' => 'required|string|min:1|confirmed',
            'password_confirmation' => 'required|string|min:1'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'company_name.required' => 'Please fill the company name.',
            'address.required' => 'Please fill the address.',
            'country.required' => 'Please fill the country.',
            'name.required' => 'Please fill the name.',
            'email.required' => 'Please fill the email.',
            'email.email' => 'Please enter a valid email address.',
            'phone_number.required' => 'Please fill the phone number.',
            'password.required' => 'Please fill the password.',
            'password.confirmed' => 'Your password and confirmation password do not match.',
            'password_confirmation.required' => 'Please fill the password confirmation.',
        ];
    }
}
