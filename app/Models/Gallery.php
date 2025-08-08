<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'image',
        'title',
        'description',
    ];
    protected static function booted()
    {
        static::deleting(function ($gallery) {
            if ($gallery->image && file_exists(public_path('gallery/' . $gallery->image))) {
                unlink(public_path('gallery/' . $gallery->image));
            }
        });
    }
}
