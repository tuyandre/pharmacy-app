<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'medecine_id'];
    public function medecine()
    {
        return $this->belongsTo('App\Models\Medecine', 'medecine_id');
    }
}
