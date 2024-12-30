@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-confirm">
        {{ session('error') }}
    </div>
@endif

<!-- Contenedor para iconos de navegación -->
<div class="iconos-agrupados">
    <a href="{{ route('home') }}" class="icono-casa">
        <img src="{{ asset('images/house.svg') }}" alt="Ir a la página principal" class="icono" width="30" height="30">
    </a>
    <a href="{{ route('crear.examen') }}" class="icono-izquierda">
        <img src="{{ asset('images/mas.svg') }}" alt="Crear formulario de examen" class="icono" width="30" height="30">
    </a>
</div>

<!-- Título de la página -->
<h1 class="titulo">Lista de Exámenes</h1>

<!-- Enlaces a hojas de estilos -->
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

<!-- Barra de búsqueda -->
<div class="buscador">
    <input type="text" id="buscador" placeholder="Buscar exámenes..." class="input-buscador">
</div>


<!-- Tabla de exámenes -->
<table class="tabla-examenes" id="tablaExamenes">
    <thead>
        <tr>
            <th>Materia</th>
            <th>Semestre</th>
            <th>Grupo</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($examenes as $examen)
            <tr>
                <td>{{ $examen->materia }}</td>
                <td>{{ $examen->grado }}</td>
                <td>{{ $examen->grupo }}</td>
                <td>{{ $examen->fecha }}</td>
                <td class="acciones">
                    <div class="botones-acciones">
                        <a href="{{ route('examenes.edit', $examen->id) }}" class="btn-editar">
                            <img src="{{ asset('images/pencil.svg') }}" alt="Editar Examen" class="icon">
                        </a>
                        <form action="{{ route('examenes.destroy', $examen->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este examen?')">
                                <img src="{{ asset('images/delete.svg') }}" alt="Eliminar Examen" class="icon">
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    // Filtrado de la tabla de exámenes
    document.getElementById('buscador').addEventListener('input', function() {
        const filtro = this.value.toLowerCase(); // Convertir el texto del buscador a minúsculas
        const filas = document.querySelectorAll('#tablaExamenes tbody tr'); // Seleccionar todas las filas del cuerpo de la tabla

        filas.forEach(fila => {
            const textoFila = fila.textContent.toLowerCase(); // Convertir el texto de la fila a minúsculas
            fila.style.display = textoFila.includes(filtro) ? '' : 'none'; // Mostrar u ocultar filas según el filtro
        });
    });

    // Ocultar alertas después de 5 segundos
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.style.display = 'none';
    }, 5000);
</script>
