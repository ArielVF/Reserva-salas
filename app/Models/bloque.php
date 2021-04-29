<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bloque extends Model
{
    use HasFactory;

    protected $table = 'bloque';
    protected $fillable = [
        'id', 
        'hora_inicio', 
        'hora_termino',
    ];
    public $timestamps = false;
}
