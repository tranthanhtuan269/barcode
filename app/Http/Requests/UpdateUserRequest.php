<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            // 'name'              => 'required|min:3|max:50|unique:users,name,'.$this->user,
            // 'email'             => 'required|regex_email:"/^[_a-zA-Z0-9-]{2,}+(\.[_a-zA-Z0-9-]{2,}+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/"|unique:users,email,'.$this->user,
            // 'role_id'           => 'required',
            'password'          => 'required|min:8|max:100',
            'confirmpassword'   => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'confirmpassword.required'  => __('messages.confirmpassword_required'),
            'confirmpassword.same'      => __('messages.confirmpassword_same'),
        ];
    }

}
