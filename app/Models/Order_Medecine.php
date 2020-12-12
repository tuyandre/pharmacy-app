<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Medecine extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'medecine_id', 'items', 'amount'
    ];
}
