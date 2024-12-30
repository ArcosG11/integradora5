<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examen;
use App\Models\ExamenPregunta;
use Smalot\PdfParser\Parser;
use App\Models\ExamenRespuesta;
class ExamenController extends Controller
{

   // ExamenController.php
public function guardarCodigo(Request $request)
{
    $codigo = $request->input('codigo');
    
    if (!$codigo) {
        return response()->json(['message' => 'El código no puede estar vacío'], 400);
    }
    
    $examen = Examen::find($request->input('examen_id'));
    if (!$examen) {
        return response()->json(['message' => 'Examen no encontrado'], 404);
    }

    // Establecer la fecha de expiración (1 hora en este caso)
    $fecha_expiracion = now()->addHour(); 

    $examen->codigo = $codigo;
    $examen->codigo_expiracion = $fecha_expiracion;
    $examen->save();

    return response()->json(['message' => 'Código guardado exitosamente']);

}

public function submitExamen(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'nombre' => 'required|string',
        'grado' => 'required|string',
        'grupo' => 'required|string',
        'respuesta' => 'required|array', // Asegúrate de que sea un array de respuestas
    ]);

    // Guardar las respuestas en la base de datos
    ExamenRespuesta::create([
        'nombre' => $request->input('nombre'),
        'grado' => $request->input('grado'),
        'grupo' => $request->input('grupo'),
        'respuestas' => $request->input('respuesta'),
    ]);

    // Volver a la página anterior con el mensaje de éxito
    return back()->with('success', '¡Felicidades! Has terminado el examen.');
}



    public function verificarCodigo(Request $request)
    {
        $codigo = $request->input('codigo');
        $examen = Examen::where('codigo', $codigo)->first();

        if ($examen) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function mostrarExamen($codigo)
    {
        $examen = Examen::where('codigo', $codigo)->first();
        $preguntas = $examen->preguntas;

        return view('exam', compact('examen', 'preguntas'));
    }










































    public function guardarRespuestas(Request $request)
    {
        $request->validate([
            'respuesta.*' => 'required|integer',
        ]);
    
        // Procesar las respuestas enviadas
        foreach ($request->respuesta as $preguntaId => $respuesta) {
            // Guardar o procesar la respuesta
            // Por ejemplo:
            // Respuesta::create([
            //     'pregunta_id' => $preguntaId,
            //     'respuesta_seleccionada' => $respuesta,
            // ]);
        }
    
        return redirect()->route('aplicar.examen')->with('success', 'Respuestas enviadas correctamente');
    }
    
    public function buscarExamen(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'materia' => 'required|string',
            'grado' => 'required|string',
            'grupo' => 'required|string',
        ]);
    
        // Buscar el examen en la base de datos
        $examen = Examen::where('materia', $request->materia)
                        ->where('grado', $request->grado)
                        ->where('grupo', $request->grupo)
                        ->first();
    
        if (!$examen) {
            return redirect()->back()->withErrors(['error' => 'No se encontró un examen con los criterios especificados.']);
        }
    
        // Cargar las preguntas asociadas al examen
        $preguntas = $examen->preguntas;
    
        // Redirigir a la vista del formulario de examen con las preguntas
        return view('examenes.formulario', compact('examen', 'preguntas'));

    }
    

    
    // Mostrar todos los exámenes
    public function index()
    {
        $examenes = Examen::all();
        return view('examenes.index', compact('examenes'));
    }

 
    
    
    

    // Crear un nuevo examen
    public function create()
    {
        return view('examenes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'materia' => 'required|string|max:255',
            'grado' => 'required|string|max:255',
            'grupo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'pregunta.*' => 'required|string',
            'respuesta_correcta.*' => 'required|in:1,2,3,4',
        ]);

        $examen = Examen::create($request->only('materia', 'grado', 'grupo', 'fecha'));

        foreach ($request->pregunta as $index => $pregunta) {
            ExamenPregunta::create([
                'examen_id' => $examen->id,
                'pregunta' => $pregunta,
                'respuesta1' => $request->respuesta1[$index],
                'respuesta2' => $request->respuesta2[$index],
                'respuesta3' => $request->respuesta3[$index],
                'respuesta4' => $request->respuesta4[$index],
                'respuesta_correcta' => $request->respuesta_correcta[$index],
            ]);
        }

        return redirect()->route('examenes.index')->with('success', 'Examen creado exitosamente');
    }

    // Editar un examen
    public function edit($id)
    {
        $examen = Examen::findOrFail($id);
        $preguntas = $examen->preguntas;
        return view('examenes.edit', compact('examen', 'preguntas'));
    }

    public function update(Request $request, $id)
    {
        $examen = Examen::findOrFail($id);
        $examen->update($request->only('materia', 'grado', 'grupo', 'fecha'));

        foreach ($request->pregunta as $index => $pregunta) {
            $preguntaRecord = $examen->preguntas[$index];
            $preguntaRecord->update([
                'pregunta' => $pregunta,
                'respuesta1' => $request->respuesta1[$index],
                'respuesta2' => $request->respuesta2[$index],
                'respuesta3' => $request->respuesta3[$index],
                'respuesta4' => $request->respuesta4[$index],
                'respuesta_correcta' => $request->respuesta_correcta[$index],
            ]);
        }

        return redirect()->route('examenes.index')->with('success', 'Examen actualizado correctamente');
    }

    // Subir un examen desde PDF
    public function subirExamen(Request $request)
    {
        $request->validate([
            'materia' => 'required|string',
            'grado' => 'required|string',
            'grupo' => 'required|string',
            'archivoPDF' => 'required|mimes:pdf|max:2048',
        ]);

        $examen = Examen::create($request->only('materia', 'grado', 'grupo', 'fecha'));

        $rutaArchivo = $request->file('archivoPDF')->store('examenes', 'public');
        $parser = new Parser();
        $texto = $parser->parseFile(storage_path('app/public/' . $rutaArchivo))->getText();

        foreach ($this->procesarPreguntas($texto) as $preguntaData) {
            ExamenPregunta::create(array_merge(['examen_id' => $examen->id], $preguntaData));
        }

        return redirect()->back()->with('success', 'Examen subido correctamente');
    }

    protected function procesarPreguntas($texto)
    {
        // Lógica de procesamiento de preguntas del PDF
        return [];
    }

    // Eliminar un examen
    public function destroy($id)
    {
        $examen = Examen::findOrFail($id);
        $examen->delete();
        return redirect()->route('examenes.index')->with('success', 'Examen eliminado correctamente');
    }

    // Aplicar un examen
    public function aplicarExamen(Request $request)
    {
        $request->validate([
            'materia' => 'required|string|max:255',
            'grado' => 'required|string|max:255',
            'grupo' => 'required|string|max:255',
        ]);

        return redirect()->back()->with('success', 'Examen aplicado correctamente');
    }
}
