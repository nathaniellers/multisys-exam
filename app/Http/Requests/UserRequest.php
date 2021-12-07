<?php

namespace App\Http\Requests;

use App\Enums\ResponseMessage;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ResponseMessage::error['email_required'],
            'email.email' => ResponseMessage::error['email_invalid'],
            'email.unique' => ResponseMessage::error['email_unique'],
            'password.required' => ResponseMessage::error['password_required']
        ];
    }
}
