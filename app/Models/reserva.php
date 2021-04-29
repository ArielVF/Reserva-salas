<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reserva extends Model
{
    use HasFactory;
    
    protected $table="reserva";
    protected $fillable = [
        'id',
        'title',
        'start',
        'end', 
        'usuario_id',
        'espacioFisico_id',
        'bloque_id'
    ];
    public $timestamps = false;
}
