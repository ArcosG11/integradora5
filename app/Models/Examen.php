<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    // En Examen.php
public function preguntas()
{
    return $this->hasMany(ExamenPregunta::class);
}


protected $fillable = ['materia', 'grado', 'grupo', 'codigo'];
    

  
}
