<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class implementos extends Model
{
    use HasFactory;

    protected $table = 'implemento';
    protected $fillable = [
        'id', 
        'nombre', 
    ];
}
