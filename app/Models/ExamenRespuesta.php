<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenRespuesta extends Model
{
    use HasFactory;

    protected $table = 'examen_respuestas';

    protected $fillable = [
        'nombre',
        'grado',
        'grupo',
        'respuestas',
    ];

    protected $casts = [
        'respuestas' => 'array', // Convierte el campo JSON en un arreglo
    ];
}
