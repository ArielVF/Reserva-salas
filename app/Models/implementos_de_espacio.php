<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class implementos_de_espacio extends Model
{
    use HasFactory;

    protected $table = 'implementos_de_espacios';
    protected $fillable = [
        'implemento_id', 
        'espacioFisico_id',
        'cantidad',
    ];
    public $timestamps = false;
}
