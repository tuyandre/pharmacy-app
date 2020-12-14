<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;


class Medecine extends Model
{
    use HasFactory;
    use MediaAlly;

    protected $fillable = ['name', 'image', 'file_url', 'description', 'price', 'numberOf', 'pharmacy_id'];

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
