<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\Api\BaseController;


class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //dd("here");
        //$this->middleware('auth:sanctum');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function uploadImage(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')){
            try {

               $user->saveImage($request->file('image'));

            }
            catch (\Exception $exception){

                return response()->json(['status' => 0, 'msg' => $exception->getMessage()]);
            }

            return response()->json(['status' => 1, 'data' => $user->image->path]);
        }

    }


}
