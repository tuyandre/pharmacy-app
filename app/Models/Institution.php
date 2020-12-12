<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'pharmacy_id'];

    public function pharmacy()
    {
        return $this->belongsTo('App\Models\Pharmacy', 'pharmacy_id');
    }
}
