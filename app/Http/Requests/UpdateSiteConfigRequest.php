<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteConfigRequest extends FormRequest
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
            'logo'      => 'required|max:255',
            'address'   => 'required',
            'email'     => 'required|max:255',
            'phone'     => 'required|max:15',
            'phone_2'   => 'required|max:15',
            'facebook'  => 'required',
            'youtube'   => 'required',
            // 'lat'       => 'required|max:255',
            // 'lng'       => 'required|max:255',
            'instagram' => 'required'
        ];
    }
}
