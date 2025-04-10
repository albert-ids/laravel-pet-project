<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
    public function rules():array
    {
        return [
            'title'       => 'required|string',
            'link'        => 'required|url|unique:posts',
            'description' => 'nullable|string',
            'pub_date'    => 'nullable|date',
        ];
    }
}
