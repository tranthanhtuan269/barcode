<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class BackendUpdateConfigHome extends FormRequest
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
            'phone_1'             => 'max:20',
            'phone_2'             => 'max:20',
            'facebook'             => 'max:500',
            'youtube'             => 'max:500',
            'instagram'             => 'max:500',
        ];
    }

}
