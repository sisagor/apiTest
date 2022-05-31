<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                    'name',
                    'type',
                    'path',
                    'extension',
                    'size',
                    'order',
                    'imageable_id',
                    'imageable_type',
                ];

    /**
     * Get all of the owning imageable models.
     */
	public function imageable()
    {
        return $this->morphTo();
    }

    public function setFeatureAttribute($value)
    {
        //$this->attributes['featured'] = (bool) $value ? $value : null;
    }

    // public function getUrlAttribute()
    // {
    //     return Storage::url($this->path);
    // }

    public function getUploadedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }


}
