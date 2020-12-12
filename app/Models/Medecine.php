<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecine extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'description', 'price', 'numberOf', 'pharmacy_id'];

    public function pharmacy()
    {
        return $this->belongsTo('App\Models\Pharmacy', 'pharmacy_id');
    }
    public function orders()
    {
        return $this->BelongsToMany(Order::class, 'order__medecines')
            ->withPivot('items', 'amount');
    }
    public function carts()
    {
        return $this->BelongsToMany(Cart::class, 'cart__medecines');
    }
}
