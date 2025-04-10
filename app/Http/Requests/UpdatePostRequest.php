<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'title'    => 'required|string',
            'link'     => 'required|url|unique:post,link,' . $this->route($id),
            'description' => 'nullable|string',
            'pub_date'    => 'nullable|date',
        ];
    }
}
