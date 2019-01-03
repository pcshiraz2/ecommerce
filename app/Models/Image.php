<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        Storage::delete($image->source);
        $image->delete();
    }
}
