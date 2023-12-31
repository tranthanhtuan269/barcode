<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'email'             => 'required|email',
            'password'          => 'required|min:8|max:100',
        ];
    }

    public function messages()
    {
        return [
            // 'email.regex_email'         => 'The email must be a valid email address.',
        ];
    }
}
