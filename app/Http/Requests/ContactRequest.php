<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'              => 'required|min:3|max:80',
            'email'             => 'required|email',
            'subject'           => 'required|min:3|max:80',
            'content'           => 'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            // 'email.regex_email'         => 'The email must be a valid email address.',
        ];
    }
}
