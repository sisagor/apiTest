<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\RootRequest;

class ImageUploadRequest extends RootRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'mimes:jpeg,jpg,png|required|max:10000'
        ];
    }


    public function message(bool $absolute = true)
    {
        /*return [];*/
    }


}
