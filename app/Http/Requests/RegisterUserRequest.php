<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            // 'name'              => 'required|min:3|max:50',
            // 'email'             => 'required|unique:users,email|regex_email:"/^[_a-zA-Z0-9-]{2,}+(\.[_a-zA-Z0-9-]{2,}+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/"',
            'email'             => 'required|unique:users|email',
            // 'phone'             => 'required|unique:users,phone|max:20|regex_phone:"/^[\+]?[(]?[0-9]{1,3}[)]?[-\s]?[0-9]{1,3}[-\s]?[0-9]{4,9}$/"',
            'password'          => 'required|min:8|max:100',
            'confirmpassword'   => 'required|same:password',
            // 'city_id'           => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'email.regex_email'         => 'The email must be a valid email address.',
            // 'phone.regex_phone'         => 'The phone must be a valid.',
            'confirmpassword.required'  => __('messages.confirmpassword_required') ,
            'confirmpassword.same'      => __('messages.confirmpassword_same'),
        ];
    }
}
