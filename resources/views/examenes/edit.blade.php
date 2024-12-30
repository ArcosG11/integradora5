@extends('layouts/main')

@section('Cobach95', 'Editar Examen')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/examenes.css') }}">

<div class="container mt-5">
    <h2>Editar Examen</h2>

    <!-- Mostrar mensajes de éxito o error -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Enlace para redirigir a la página principal y a la página de índice -->
    <div class="iconos-container">
        <a href="{{ route('home') }}" class="icono-casa">
            <img src="{{ asset('images/house.svg') }}" alt="Ir a la página principal" class="icono">
        </a>
        <a href="{{ route('examenes.index') }}" class="icono-lista">
            <img src="{{ asset('images/list.svg') }}" alt="Ir a la lista de exámenes" class="icono">
        </a>
    </div>
    <!-- Formulario de Edición -->
    <form id="formulario-examen" action="{{ route('examenes.update', $examen->id) }}" method="POST">
        @csrf
        @method('PUT')
    
        <!-- Materia, Grado, Grupo y Fecha -->
        <div class="row mb-4">
            <div class="col-md-3">
                <label for="materia" class="form-label">Materia</label>
                <input type="text" name="materia" id="materia" class="form-control" value="{{ old('materia', $examen->materia) }}" required>
            </div>
            <div class="col-md-3">
                <label for="grado" class="form-label">semestre</label>
                <input type="text" name="grado" id="grado" class="form-control" value="{{ old('grado', $examen->grado) }}" required>
            </div>
            <div class="col-md-3">
                <label for="grupo" class="form-label">Grupo</label>
                <input type="text" name="grupo" id="grupo" class="form-control" value="{{ old('grupo', $examen->grupo) }}" required>
            </div>
            <div class="col-md-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $examen->fecha) }}" required>
            </div>
        </div>
    
        <!-- Preguntas y respuestas -->
        <div class="pregunta-container" id="pregunta-container">
            @foreach($preguntas as $index => $pregunta)
                <div class="mb-3 pregunta-form" id="pregunta-form-{{ $index+1 }}">
                    <label for="pregunta{{ $index+1 }}" class="form-label">Pregunta</label>
                    <textarea name="pregunta[]" id="pregunta{{ $index+1 }}" class="form-control" rows="4" required oninput="ajustarAltura(this)">{{ old('pregunta.' . $index, $pregunta->pregunta) }}</textarea>
                </div>
    
                <!-- Respuestas -->
                @foreach(range(1, 4) as $i)
                    <div class="mb-3 d-flex align-items-center">
                        <label for="respuesta{{ $i }}-{{ $index+1 }}" class="form-label me-2">{{ chr(64 + $i) }})</label>
                        <input type="text" name="respuesta{{ $i }}[]" id="respuesta{{ $i }}-{{ $index+1 }}" class="form-control linea-respuesta" value="{{ old('respuesta' . $i . '.' . $index, $pregunta->{'respuesta' . $i}) }}" required>
                    </div>
                @endforeach
    
                <!-- Respuesta correcta -->
                <div class="mb-3">
                    <label for="respuesta_correcta{{ $index+1 }}" class="form-label">Respuesta Correcta</label>
                    <select name="respuesta_correcta[]" id="respuesta_correcta{{ $index+1 }}" class="form-select" required>
                        <option value="1" {{ old('respuesta_correcta.' . $index, $pregunta->respuesta_correcta) == 1 ? 'selected' : '' }}>A)</option>
                        <option value="2" {{ old('respuesta_correcta.' . $index, $pregunta->respuesta_correcta) == 2 ? 'selected' : '' }}>B)</option>
                        <option value="3" {{ old('respuesta_correcta.' . $index, $pregunta->respuesta_correcta) == 3 ? 'selected' : '' }}>C)</option>
                        <option value="4" {{ old('respuesta_correcta.' . $index, $pregunta->respuesta_correcta) == 4 ? 'selected' : '' }}>D)</option>
                    </select>
                </div>
            @endforeach
        </div>
    
        <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-rojo" id="agregar-pregunta">Agregar otra pregunta</button>
            <button type="submit" class="btn btn-primary">Guardar Examen</button>
        </div>
    </form>
    
</div>

<script>
    let preguntaCount = {{ count($examen->preguntas) }};

    // Función para ajustar la altura del textarea mientras se escribe
    function ajustarAltura(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }

    // Función para agregar una nueva pregunta automáticamente
    document.getElementById('agregar-pregunta').addEventListener('click', function () {
        preguntaCount++;

        let preguntaContainer = document.getElementById('pregunta-container');
        let nuevaPreguntaForm = `
            <div class="mb-3 pregunta-form" id="pregunta-form-${preguntaCount}">
                <label for="pregunta${preguntaCount}" class="form-label">Pregunta</label>
                <textarea name="pregunta[]" id="pregunta${preguntaCount}" class="form-control" rows="4" required oninput="ajustarAltura(this)"></textarea>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="respuesta1" class="form-label me-2">A)</label>
                <input type="text" name="respuesta1[]" id="respuesta1" class="form-control linea-respuesta" required>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="respuesta2" class="form-label me-2">B)</label>
                <input type="text" name="respuesta2[]" id="respuesta2" class="form-control linea-respuesta" required>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="respuesta3" class="form-label me-2">C)</label>
                <input type="text" name="respuesta3[]" id="respuesta3" class="form-control linea-respuesta" required>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="respuesta4" class="form-label me-2">D)</label>
                <input type="text" name="respuesta4[]" id="respuesta4" class="form-control linea-respuesta">
            </div>
            <div class="mb-3">
                <label for="respuesta_correcta" class="form-label">Respuesta Correcta</label>
                <select name="respuesta_correcta[]" id="respuesta_correcta" class="form-select" required>
                    <option value="1">A)</option>
                    <option value="2">B)</option>
                    <option value="3">C)</option>
                    <option value="4">D)</option>
                </select>
            </div>
        `;
        preguntaContainer.insertAdjacentHTML('beforeend', nuevaPreguntaForm);
    });
</script>

@endsection
