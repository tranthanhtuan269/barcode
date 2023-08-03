<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            // 'name'          => 'required|max:255|unique:categories,name',
            'number_day'          => 'required|numeric|min:0',
            'expried_date'          => 'required|numeric|min:0',
            'price'          => 'required|numeric|min:0',
            'permission_reserve'          => 'required',
            'apply_from'                   => 'required|date_format:d/m/Y|validate_time',
            'apply_to'                   => 'required|date_format:d/m/Y|after:apply_from',
            // 'description'    => 'required',
            'keyword'       => 'max:255',
            'seo_title'         => 'max:255',
        ];
    }

    public function messages()
    {
        return [
            'apply_from.validate_time'      => 'Khoảng thời gian áp dụng đã trùng với khoảng thời gian khác.',
        ];
    }
}
