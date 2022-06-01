<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Requests\Api\ImageUploadRequest;
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
    public function uploadImage(ImageUploadRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')){
            try {

               $user->saveImage($request->file('image'));

            }
            catch (\Exception $exception){

                return $this->handleError($exception->getMessage());
            }

            return $this->handleResponse($user->image->path, "image upload success");
        }

    }


}
