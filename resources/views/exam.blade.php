@extends('layouts.main')

@section('contenido')
    <div class="container py-5">
        <h1 class="text-center mb-4 text-primary">
            <i class="fas fa-clipboard-list"></i> Examen de {{ $examen->materia }}
        </h1>
        <p class="text-center text-muted mb-5">
            <strong>Semestre:</strong> {{ $examen->grado }} | <strong>Grupo:</strong> {{ $examen->grupo }}
        </p>

        <!-- Mostrar el mensaje de éxito si existe -->
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>

            <!-- Botón "Cerrar sesión" centrado, solo se muestra después del mensaje de éxito -->
            <div class="d-flex justify-content-center mt-5">
                <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar sesión</a>
            </div>

            <script>
                // Prevenir la recarga de la página
                window.onload = function() {
                    // Deshabilitar el botón de recarga (F5) y la recarga con Ctrl+R
                    window.addEventListener('beforeunload', function (event) {
                        event.preventDefault();
                        event.returnValue = ''; // Mostrar el mensaje de advertencia si intentan recargar
                    });
                };
            </script>
        @else
            <!-- El formulario del examen solo se muestra si no hay mensaje de éxito -->
            <form id="examenForm" method="POST" action="{{ route('examen.submitExamen') }}">
                @csrf
                <div class="mb-4">
                    <label for="nombre" class="form-label">Nombre del Estudiante</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa tu nombre" required>
                </div>
                <div class="mb-4">
                    <label for="grado" class="form-label">Grado</label>
                    <input type="text" id="grado" name="grado" class="form-control" placeholder="Ingresa tu grado" required>
                </div>
                <div class="mb-4">
                    <label for="grupo" class="form-label">Grupo</label>
                    <input type="text" id="grupo" name="grupo" class="form-control" placeholder="Ingresa tu grupo" required>
                </div>

                @foreach ($preguntas as $index => $pregunta)
                    <div class="card shadow-lg mb-4">
                        <div class="card-body">
                            <label class="h5 mb-3 text-dark"><strong>Pregunta {{ $index + 1 }}</strong></label>
                            <p class="mb-3">{{ $pregunta->pregunta }}</p>
                            <div class="options">
                                @foreach(range(1, 4) as $i)
                                    <div class="form-check">
                                        <input type="radio" name="respuesta[{{ $pregunta->id }}]" value="{{ $i }}" class="form-check-input" required>
                                        <label class="form-check-label">{{ chr(96 + $i) }} {{ $pregunta->{'respuesta' . $i} }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Enviar Examen</button>
                </div>
            </form>
        @endif
    </div>
@endsection
