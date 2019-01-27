<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        Storage::delete($image->source);
        $image->delete();
    }
}
