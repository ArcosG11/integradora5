@extends('layouts/main')

@section('titulo_pagina', 'Login de usuario')

@section('contenido')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-4 shadow-lg">
                    <h2 class="text-center mt-4">Hola! Ingrese sus credenciales por favor.</h2>
                    <div class="card-body">
                        <form action="{{ route('loguear') }}" method="post" id="loginForm">
                            @csrf
                            @method('post')

                            <!-- Selección de tipo de usuario -->
                            <div class="form-group">
                                <label for="usuario">Tipo de usuario</label>
                                <select name="usuario" id="usuario" class="form-control" onchange="checkUserType()">
                                    <option value="docente">Docente</option>
                                    <option value="alumno">Alumno</option>
                                </select>
                            </div>

                            <!-- Campo de correo -->
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>

                            <!-- Campo de contraseña -->
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <!-- Botón para enviar el formulario -->
                            <div class="form-group text-center">
                                <button class="btn btn-primary mt-4" type="submit">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkUserType() {
            var userType = document.getElementById('usuario').value;
            if (userType === 'alumno') {
                // Redirigir a la página de examen si es alumno
                window.location.href = "{{ route('examen') }}";
            }
        }
    </script>

    <style>
        /* Fondo general de la página */
        body {
            background-color: #f6f6f6; /* Gris suave para el fondo */
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            padding-top: 50px;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            background-color: #ffffff; /* Fondo blanco para la tarjeta */
            border: 1px solid #ddd; /* Borde gris claro */
        }

        .card-body {
            padding: 2rem;
        }

        h2 {
            font-size: 1.75rem;
            color: #0a0b4c; /* Título en color azul oscuro */
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #0a0b4c; /* Color del texto de las etiquetas */
        }

        .form-control {
            margin-bottom: 15px;
            border-radius: 8px;
            background-color: #fafafa; /* Fondo claro para los campos */
            border: 1px solid #ccc; /* Borde claro */
            padding: 10px;
            box-shadow: inset 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
            border-color: #0a0b4c;
        }

        .btn-primary {
            background-color: #0a0b4c; /* Fondo oscuro para el botón */
            border-color: #0a0b4c;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .text-center {
            text-align: center;
        }

        /* Sombra sutil en la tarjeta */
        .card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
