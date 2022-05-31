<?php

namespace App\Common;


use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

/**
 * Attach this Trait to a User
 *
 * @author Inta-Dev
 */
trait Imageable
{

    /**
     * Check if model has an images.
     *
     * @return bool
     */
    public function hasImages()
    {
        return (bool)$this->images()->count();
    }

    /**
     * Return collection of images related to the imageable
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')
            ->where(function ($q) {
                $q->whereNull('type');
            })->orderBy('order', 'asc');
    }

    /**
     * Createing image
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Return the logo related to the logoable
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function logo()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'logo');
    }


    //Employee Image
    public function employeeImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'employee');
    }


    /**
     * Return the featured Image related to the imageable
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function profile()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'profile');
    }

    /**
     * Return the featured Image related to the imageable
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function coverImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'cover');
    }

    /**
     * Return the Background Image related to the imageable
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function backgroundImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'background');
    }

    /**
     * Save images
     *
     * @param file $image
     * @return image model
     */
    public function saveImage($image, $type = null)
    {
        $dir = 'images';
         if(! Storage::exists($dir)) {
             Storage::disk('public')->makeDirectory($dir, 0775, true, true);
         }
        $path = Storage::disk('public')->put($dir, $image);

        return $this->createImage($path, $image->getClientOriginalName(), $image->getClientOriginalExtension(), $image->getSize(), $type);
    }

    /**
     * Update images
     *
     * @param file $image
     * @return image model
     */
    public function updateImage($image, $type = null)
    {
        // Delete the old image if exist
        $this->deleteImageTypeOf($type);

        return $this->saveImage($image, $type);
    }


    /**
     * Deletes the special type of image of this model.
     *
     * @return bool
     */
    public function deleteImageTypeOf($type)
    {
        if ($type) {
            // Delete the old image if exist
            $rel = $type;
            if ($img = $this->$rel) {
                $this->deleteImage($img);
            }
        }

        return;
    }

    /**
     * Deletes the Brand Logo Image of this model.
     *
     * @return bool
     */
    public function deleteLogo()
    {
        // Will be removed
        if ($img = $this->logo) {
            $this->deleteImage($img);
        }

        return;
    }

    /**
     * Deletes all the images of this model.
     *
     * @return bool
     */
    public function flushImages()
    {
        foreach ($this->images as $image) {
            $this->deleteImage($image);
        }

        $this->deleteLogo();

        return;
    }

    /**
     * Create image model
     *
     * @return array
     */
    private function createImage($path, $name, $ext = '.jpeg', $size = Null, $type = Null)
    {
        return $this->image()->create([
            'path' => $path,
            'name' => $name,
            'type' => $type,
            'extension' => $ext,
            'size' => $size,
        ]);
    }

}
