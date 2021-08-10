<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentGalleryRequest extends FormRequest
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
        if ($this->group_type == 'gallery') {
            return [
                'photos' => 'required|string|min:1'
            ];    
        }
        return [
            'document_file' => 'required|string|min:1'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        if ($this->group_type == 'gallery') {
            return [
                'photos.required' => 'Please add at least 1 gallery image.'
            ];
        }
        return [
            'document_file.required' => 'Please add document file.',
        ];
    }
}
