<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassUserRequest extends FormRequest
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
            'password_old'=>'required|check_pass',
            'password'=>'required|min:8|max:32|different:password_old',
            'confirmpassword'=>'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'password_old.check_pass'      => __('messages.password_old_check_pass'),
            'confirmpassword.required'     => __('messages.confirmpassword_required'),
            'confirmpassword.same'         => __('messages.confirmpassword_same'),
        ];
    }
}
