<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class espacio_fisico extends Model
{
    use HasFactory;
    
    protected $table = "espacio_fisico";
    protected $fillable = [
        'descripcion', 
        'sillas',
    ];
}
