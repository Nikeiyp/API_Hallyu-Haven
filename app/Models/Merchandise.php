<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    protected $table = 'merchandise'; 

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image'
    ];
}
