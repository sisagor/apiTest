<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\RootRequest;

class LoginRequest extends RootRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ];

    }


    public function message(bool $absolute = true)
    {
        /*return [];*/
    }


}
