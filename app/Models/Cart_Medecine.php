<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_Medecine extends Model
{
    use HasFactory;
    protected $fillable = [
        'cart_id', 'medecine_id'
    ];
}
