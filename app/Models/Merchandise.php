<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    use HasFactory;

    protected $table = 'merchandise'; 
    protected $fillable = [
        'name', 'price', 'image', 'description'
    ];
}
