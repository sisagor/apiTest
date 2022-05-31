<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    public function handleResponse($result, $msg)
    {
        $res = [
            'status' => true,
            'data'    => $result,
            'message' => $msg,
        ];
        return \response()->json($res, 200);
    }

    public function handleError($error, $errorMsg = [], $code = 404)
    {
        $res = [
            'status' => false,
            'message' => $error,
        ];
        if(!empty($errorMsg)){
            $res['data'] = $errorMsg;
        }
        return response()->json($res, $code);
    }

}
