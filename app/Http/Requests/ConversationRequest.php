<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConversationRequest extends FormRequest
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
            //
            'title' => 'required|string|min:1',
            'message' => 'required|string|min:1',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'The title field is required',
            'message.required' => 'The message field is required.',
        ];
    }
}
