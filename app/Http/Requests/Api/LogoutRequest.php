<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\RootRequest;

class LogoutRequest extends RootRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'token' => 'required'
        ];
    }


    public function message(bool $absolute = true)
    {
        /*return [];*/
    }


}
