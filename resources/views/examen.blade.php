<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Acceso</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #4e73df;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1.2rem;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #4e73df;
            outline: none;
            box-shadow: 0 0 5px rgba(78, 115, 223, 0.5);
        }

        .btn {
            width: 100%;
            padding: 0.9rem;
            font-size: 1.1rem;
            color: white;
            background-color: #4e73df;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #3658c6;
        }

        /* Estilo para el mensaje de éxito */
        .success-message {
            color: green;
            font-size: 1rem;
            margin-top: 1rem;
            text-align: center;
        }

        /* Estilo para el mensaje de error */
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Acceder al Examen</h2>
        
        <!-- Campo para ingresar el código -->
        <div class="mb-4">
            <label for="codigoAcceso" class="form-label">Código de Acceso</label>
            <input type="text" id="codigoAcceso" class="form-control" placeholder="Ingresa el código de acceso">
        </div>

        <!-- Botón para verificar el código -->
        <button type="button" class="btn" onclick="verificarCodigo()">Acceder al examen</button>

        <!-- Mensajes -->
        <div id="mensaje" class="error-message" style="display:none;"></div>
    </div>

    <script>
        function verificarCodigo() {
            var codigo = document.getElementById('codigoAcceso').value;
            var mensaje = document.getElementById('mensaje');
            if (codigo === "") {
                mensaje.textContent = "Por favor ingresa un código.";
                mensaje.style.display = "block";
                return;
            }

            // Realizar la verificación del código a través de la API
            fetch("{{ route('verificar.codigo') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    codigo: codigo
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mensaje.textContent = "Código encontrado. Accediendo al examen...";
                    mensaje.style.color = "green";
                    mensaje.style.display = "block";
                    // Redirigir a la página del examen con el código
                    window.location.href = "{{ url('exam') }}/" + codigo;
                } else {
                    mensaje.textContent = "Código no encontrado. Intenta nuevamente.";
                    mensaje.style.display = "block";
                    mensaje.style.color = "red";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mensaje.textContent = "Ocurrió un error al verificar el código.";
                mensaje.style.display = "block";
            });
        }
    </script>
</body>
</html>
