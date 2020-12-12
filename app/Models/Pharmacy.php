<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'location', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function institutions()
    {
        return $this->hasMany('App\Models\Institution');
    }
    public function medecines()
    {
        return $this->hasMany('App\Models\Medecine');
    }
}
