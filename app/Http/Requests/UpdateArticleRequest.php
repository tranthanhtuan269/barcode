<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'title'          => 'required|max:100|unique:articles,title,'.$this->article,
            'image'   => 'required', 
            // 'description'        => 'required', 
            'content'          => 'required',
            'image'          => 'required',
            'keywords'      => 'max:255', 
            'seo_title'         => 'max:255', 
        ];
    }
}
