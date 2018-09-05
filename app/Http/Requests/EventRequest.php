<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize()
    {
        // Using policy for Authorization
        return true;
    }
    public function rules()
    {



        return [
            // UPDATE ROLES
            'email'       => 'required|min:10',
            'password'        => 'required|min:6',
        ];


    }

    public function messages()
    {
        return [
            // Validation messages
            'name.min' => '标题必须至少两个字符',
            'password.min' => '文章内容必须至少三个字符',
        ];
    }
}
