<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EskulRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2000',
            'name' => 'required|string',
            'content' => 'required|string'
        ];
    }
}
