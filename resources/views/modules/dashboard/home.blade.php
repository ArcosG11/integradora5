@extends('layouts/main')

@section('Cobach95', 'Home')

@section('contenido')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid">
    <div class="row">
        <!-- Menú Vertical -->
        <div class="col-md-4 sidebar">
            <ul class="menu">
                <li><a href="#">Docentes</a></li>
                <li><a href="#">Alumnos</a></li>
            </ul>
        </div>

        <!-- Contenido Principal -->
        <div class="col-md-8 d-flex justify-content-start align-items-center">
            <div class="row text-center">
                <!-- Crear Examen -->
                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="content-box" data-bs-toggle="modal" data-bs-target="#modalCrearExamen">
                        <img src="{{ asset('images/pencil.svg') }}" alt="Crear Examen" class="icon">
                        <h3>Crear Examen</h3>
                        <p class="description">Crea exámenes para evaluar a los estudiantes en las materias correspondientes.</p>
                    </div>
                </div>
                <!-- Aplicar Examen -->
                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="content-box" data-bs-toggle="modal" data-bs-target="#modalAplicarExamen">
                        <img src="{{ asset('images/exam.svg') }}" alt="Aplicar Examen" class="icon">
                        <h3>Aplicar Examen</h3>
                        <p class="description">Aplica los exámenes creados para que los estudiantes los resuelvan.</p>
                    </div>
                </div>
                <!-- Otros ítems -->
                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="content-box">
                        <img src="{{ asset('images/asistencia.svg') }}" alt="Asistencia" class="icon">
                        <h3>Asistencia</h3>
                        <p class="description">Lleva un registro de la asistencia de los estudiantes a clases.</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="content-box">
                        <img src="{{ asset('images/star.svg') }}" alt="Calificaciones Actuales" class="icon">
                        <h3>Calificaciones Actuales</h3>
                        <p class="description">Consulta las calificaciones actuales de los estudiantes en las materias.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal "Crear Examen" -->
<div class="modal fade" id="modalCrearExamen" tabindex="-1" aria-labelledby="modalCrearExamenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearExamenLabel">Selecciona una opción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Qué tipo de examen deseas crear?</p>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('crear.examen') }}" class="btn btn-primary">Crear formulario de examen</a>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalSubirArchivo">
                        Subir archivo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal "Aplicar Examen" -->
<div class="modal fade" id="modalAplicarExamen" tabindex="-1" aria-labelledby="modalAplicarExamenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAplicarExamenLabel">Aplicar Examen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('aplicar.examen') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="materia">Materia</label>
                        <input type="text" class="form-control" id="materia" name="materia" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="grado">Semestre</label>
                        <input type="text" class="form-control" id="grado" name="grado" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="grupo">Grupo</label>
                        <input type="text" class="form-control" id="grupo" name="grupo" required>
                    </div>
                    <button type="submit" class="btn btn-success mt-4">Buscar</button>
                </form>

                @if(isset($preguntas) && count($preguntas) > 0)
                    <hr>
                    <form action="{{ route('guardar.respuestas') }}" method="POST">
                        @csrf
                        @foreach($preguntas as $pregunta)
                            <div class="form-group mt-3">
                                <label>{{ $pregunta->texto }}</label>
                                @foreach($pregunta->respuestas as $respuesta)
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="respuesta[{{ $pregunta->id }}]" value="{{ $respuesta->id }}" required>
                                        <label class="form-check-label">{{ $respuesta->texto }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary mt-4">Enviar Respuestas</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- Modal "Subir Archivo PDF" -->
<div class="modal fade" id="modalSubirArchivo" tabindex="-1" aria-labelledby="modalSubirArchivoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSubirArchivoLabel">Subir archivo de examen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subir.examen') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="materia">Materia</label>
                        <input type="text" class="form-control" id="materia" name="materia" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="grado">Grado</label>
                        <input type="text" class="form-control" id="grado" name="grado" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="grupo">Grupo</label>
                        <input type="text" class="form-control" id="grupo" name="grupo" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="archivoPDF">Sube tu archivo </label>
                        <input type="file" class="form-control" id="archivoPDF" name="archivoPDF" accept=".pdf" required>
                    </div>
                    <button type="submit" class="btn btn-success mt-4">Subir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Botón de Cerrar Sesión -->
<div class="logout-button">
    <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar sesión</a>
</div>

<!-- Pie de página -->
<footer class="footer">
    <div class="container">
        <p class="text-center">© 2024 Colegio de Bachilleres de Chiapas Plantel 95 Cenobio Aguilar.</p>
    </div>
</footer>

@endsection
