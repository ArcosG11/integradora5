@extends('layouts/main')

@section('Cobach95', 'Vista Previa del Examen')

@section('contenido')
<div class="container py-5">
    <h1 class="text-center mb-4 text-primary">
        <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
        <i class="fas fa-clipboard-list"></i> Examen de {{ $examen->materia }}
    </h1>
    <p class="text-center text-muted mb-5">
        <strong>Semestre:</strong> {{ $examen->grado }} | <strong>Grupo:</strong> {{ $examen->grupo }}
    </p>

    <form id="codigoForm">
    <!-- Contenedor para el código generado y los botones -->
    <div class="d-flex justify-content-end mb-4">
        <input type="text" id="codigoGenerado" class="form-control me-3" placeholder="" readonly style="max-width: 200px;">
        <button type="button" class="btn btn-primary px-4 py-2" onclick="generarCodigo()">
            Generar Código
        </button>
        <button type="button" class="btn btn-success px-4 py-2 ms-3" onclick="guardarCodigo()">
            Guardar Código
        </button>
    </div>

    <!-- Campo para ingresar duración del código -->
    <div class="mb-3">
        <label for="duracion" class="form-label">Duración del código (en horas)</label>
        <input type="number" id="duracion" class="form-control" min="1" value="1">
    </div>

    @foreach ($preguntas as $index => $pregunta)
        <div class="card shadow-lg mb-4">
            <div class="card-body">
                <label class="h5 mb-3 text-dark"><strong>Pregunta {{ $index + 1 }}</strong></label>
                <p class="mb-3">{{ $pregunta->pregunta }}</p>
                <div class="options">
                    @foreach(range(1, 4) as $i)
                        <div class="form-check">
                            <input type="radio" disabled name="respuesta[{{ $pregunta->id }}]" value="{{ $i }}" class="form-check-input">
                            <label class="form-check-label">{{ chr(96 + $i) }} {{ $pregunta->{'respuesta' . $i} }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</form>

<script>
    function generarCodigo() {
        var codigo = Math.floor(10000 + Math.random() * 90000);
        document.getElementById('codigoGenerado').value = codigo;
    }

    // Función para guardar el código con la duración
    function guardarCodigo() {
        var codigo = document.getElementById('codigoGenerado').value;
        var duracion = document.getElementById('duracion').value; // Duración en horas
        if (codigo === "") {
            alert("Por favor, genera un código antes de guardar.");
            return;
        }

        var examenId = {{ $examen->id }}; // El ID del examen que estás editando

        fetch("{{ route('guardar.codigo') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                codigo: codigo,
                examen_id: examenId,
                duracion: duracion
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Mostrar mensaje de éxito
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al guardar el código.');
        });
    }
</script>


@endsection
