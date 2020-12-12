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
    public function orders()
    {
        return $this->BelongsToMany(Cart::class, 'order_books')
            ->withPivot('items', 'amount');
    }
}
