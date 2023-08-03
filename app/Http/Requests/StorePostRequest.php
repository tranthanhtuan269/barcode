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
    public function rules()
    {
        return [
            'title'          => 'required|max:255|unique:posts,title', 
            'image'        => 'required', 
            'content'        => 'required', 
            'cat_id'   => 'required',
            'keywords'      => 'max:255', 
            'seo_title'         => 'max:255', 
        ];
    }
}
