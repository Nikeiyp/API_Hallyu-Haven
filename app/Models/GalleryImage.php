<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['merchandise_id', 'image'];

    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class);
    }
}
