<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenPregunta extends Model
{
    use HasFactory;

    // Relación con el modelo Examen
    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    // Nombre de la tabla
    protected $table = 'examen_preguntas'; 

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'examen_id',   // Clave foránea para el examen
        'pregunta', 
        'respuesta1', 
        'respuesta2', 
        'respuesta3', 
        'respuesta4', 
        'respuesta_correcta',
    ];
}
