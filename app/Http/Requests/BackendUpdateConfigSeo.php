<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class BackendUpdateConfigSeo extends FormRequest
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
            'keywords'             => 'max:500',
            'seo_title'             => 'max:500',
            'seo_description'             => 'max:500',
        ];
    }
}
