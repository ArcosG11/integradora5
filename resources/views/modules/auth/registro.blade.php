@extends('layouts/main')
@section('Registro de docentes')
    
@section('contenido')
<div class="container">
    <div class="row">
        <div class="col">
          <div class="card mt-4">
            <h2>Registro de usuarios</h2>
            <div class="card-body">
                <form action="{{ route('registrar') }}" method="POST">
                    @csrf
                    @method('post')
                    <label for="name">Nombre del docente</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <label for="email">Correo</label>
                    <input type="email" class="form-control" name="email" id="email">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <button class="btn btn-primary mt-4">Crear usuario</button>
                    <a href=""></a>
                </form>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection