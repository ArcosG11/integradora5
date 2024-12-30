<?php

namespace App\Http\Controllers;

use App\Models\ExamenPregunta; // Asegúrate de que este modelo esté correctamente importado
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    public function destroy($id)
{
    $pregunta = Pregunta::find($id);

    if ($pregunta) {
        $pregunta->delete();
        return redirect()->route('examenes.index')->with('success', 'Pregunta eliminada correctamente.');
    } else {
        return redirect()->route('examenes.index')->with('error', 'La pregunta no fue encontrada.');
    }
}
}