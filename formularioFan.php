<?php
   session_start();

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $host = 'localhost'; // Cambiar por tu host
       $usuario = 'root'; // Cambiar por tu usuario de la base de datos
       $nombre_base_datos = 'BaseMusicas'; // Cambiar por el nombre de tu base de datos

       // Crear conexión
       $con = mysqli_connect($host, $usuario, '', $nombre_base_datos) or die("Problemas con la conexión a la base de datos"); 

       // Establecer la codificación de caracteres a UTF-8
       mysqli_set_charset($con, "utf8");

       // Obtener los valores del formulario
       $contraseña = $_POST['password'];
       $email = $_POST['email'];
       $nombreUsuario = $_POST['nombre'];
       $rol = "fan";
       $fechaAlta = date('Y-m-d'); // Obtiene la fecha actual en formato 'Año-Mes-Día'

       // Codificar la contraseña para guardarla de forma segura
       $hash = password_hash($contraseña, PASSWORD_DEFAULT);

       // Preparar la consulta SQL para insertar el nuevo usuario en la base de datos
       $sql = "INSERT INTO Usuarios (NombreUsuario, Correo, ContraseñaHash, Rol, FechaCreacionPerfil) VALUES (?, ?, ?, ?, ?)";
       $stmt = $con->prepare($sql);

       // Vincular los parámetros a la declaración preparada
       $stmt->bind_param("sssss", $nombreUsuario, $email, $hash, $rol, $fechaAlta);

       // Ejecutar la consulta
       if ($stmt->execute()) {
           $_SESSION['resultadoRegistro'] = "Usuario registrado con éxito.";
       } else {
           $_SESSION['resultadoRegistro'] = "Error al registrar el usuario: " . $stmt->error;
       }

       // Cerrar la declaración preparada y la conexión a la base de datos
       $stmt->close();
       $con->close();

       // Redirige a la misma página para mostrar el mensaje
       header("Location: " . $_SERVER['PHP_SELF']);
       exit; // Asegúrate de llamar a exit después de header() para detener la ejecución del script
   }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2D2C2C;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type=text],
        input[type=password],
        input[type=email] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* Added for proper sizing */
        }
        input[type=submit] {
            background-color: #A2E578;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type=submit]:hover {
            background-color: #84D553;
        }
        .terms {
            margin: 20px 0;
            font-size: 0.9em;
        }
        .error {
        color: red; /* Color del texto del mensaje de error */
        display: none; /* Oculto por defecto */
        font-size: 0.9em; /* Un tamaño de fuente más pequeño que el texto del input */
        margin-top: 5px; /* Espacio entre el input y el mensaje de error */
        }
        .registro {
        color: rgb(134, 187, 248);
        display: none; 
        font-size: 0.9em; 
        margin-top: 5px; 
        }
        .rotulo{
        /*background-color: #EFEFEF; */
        border-radius: 9px 9px 0px 0px;
        padding: 3px;
        text-align: center;
        font-size: 24px;
        }

        /* El Botón Close (x) */
        .close {
            color: black;
            float: right;
            font-size: 20px;
            font-weight: bold;
            padding: 7px;
        
        }

      
    </style>

    <script>
     document.addEventListener('DOMContentLoaded', (event) => {

        document.getElementById('username').setAttribute('value', '');
        document.getElementById('password').setAttribute('value', ''); 
       document.getElementById('miFormulario').onsubmit = function() {
        var email = document.getElementById('email').value;
        var confirmEmail = document.getElementById('confirm-email').value;
        var emailError = document.getElementById('email-error'); // Define correctamente la variable aquí
            if(email !== confirmEmail) {
                emailError.textContent = 'Los emails no coinciden.';
                emailError.style.display = 'block'; // Asegúrate de que el CSS muestre este span
                return false;
              }
        
                emailError.style.display = 'none';
                return true;
               }
        });


    </script>
</head>
<body>
    <form action="FormularioFan.php" method="post" id="miFormulario"  autocomplete="nope">
       <div class="rotulo">
        <a href="Index.php">
        <span class="close">&times;</span></a>
        <h2>Registro para una cuenta de Fan</h2>
       </div> 
        <label for="nombre">Nombre de usuario</label>
        <input type="text" id="username" name="nombre" pattern="[a-zñA-ZÑ0-9\-_]+" required 
        oninvalid="this.setCustomValidity('Completa este campo usando unicamente letras, numeros, - y _')"
        oninput="this.setCustomValidity('')">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
        oninvalid="this.setCustomValidity('La contraseña debe contener al menos 8 caracteres, mayusculas, minusculas, algun numero y algun caracter especial (@$!%*?&)')"
        oninput="this.setCustomValidity('')">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" pattern="^[a-zA-Z0-9\-_\.]+@[a-zA-Z]+\.(com|net|es)$"    required
        oninvalid="this.setCustomValidity('Escribe una direccion  de correo valida')"
        oninput="this.setCustomValidity('')">

        <label for="confirm-email">Confirmación email</label>
        <input type="email" id="confirm-email" name="confirmEmail" required>
        <span id="email-error" class="error"></span>

        <div class="terms">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">He leido y estoy de acuerdo con los terminos de uso.</label>
        </div>

        <input type="submit" value="Registrarse">
        <?php if (!empty($_SESSION['resultadoRegistro'])): ?>
      <span id="resultadoRegistro" class="registro" style="display: block;">
        <?php echo $_SESSION['resultadoRegistro']; ?>
      </span>
        <?php unset($_SESSION['resultadoRegistro']); // Limpia la variable de sesión después de mostrarla ?>
        <?php endif; ?>

    </form>

</body>
</html>


