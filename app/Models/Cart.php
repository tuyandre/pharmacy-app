<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function medecines()
    {
        return $this->BelongsToMany(Medecine::class, 'cart__medecines');
    }
}
