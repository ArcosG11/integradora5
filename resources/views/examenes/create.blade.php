@extends('layouts/main')

@section('Cobach95', 'Crear Examen')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/examenes.css') }}">


<div class="container mt-5">
    <h2>Crear Examen</h2>

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
    
    
    

    <!-- Campos Materia, Grado, Grupo y Fecha -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="formulario-examen" action="{{ route('examenes.store') }}" method="POST">
        @csrf

        <div class="row mb-4">
            <div class="col-md-3">
                <label for="materia" class="form-label">Materia</label>
                <input type="text" name="materia" id="materia" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label for="grado" class="form-label">Semestre</label>
                <input type="text" name="grado" id="grado" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label for="grupo" class="form-label">Grupo</label>
                <input type="text" name="grupo" id="grupo" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>
        </div>

        <div class="pregunta-container" id="pregunta-container">
            <div class="mb-3 pregunta-form" id="pregunta-form-1">
                <label for="pregunta1" class="form-label">Pregunta</label>
                <textarea name="pregunta[]" id="pregunta1" class="form-control" rows="4" required oninput="ajustarAltura(this)"></textarea>
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
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-rojo" id="agregar-pregunta">Agregar otra pregunta</button>
            <button type="submit" class="btn btn-primary">Guardar Examen</button>
        </div>
    </form>
</div>

<script>
    let preguntaCount = 1;

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

    // Bloquear fechas pasadas en el campo de fecha
    document.addEventListener('DOMContentLoaded', function () {
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); // Los meses empiezan desde 0
    let yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;

    document.getElementById('fecha').setAttribute('min', today);
});
</script>

@endsection
