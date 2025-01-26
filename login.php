<?php
       session_start();
       $_SESSION['resultadoRegistro'];
       
	   

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
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
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h2 {
            text-align: center;
            margin: 0 0 20px 0;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: calc(100% - 0px); /* Ajuste para el ancho total teniendo en cuenta el padding */
            padding: 10px; /* Padding uniforme */
            margin-bottom: 10px; /* Margen uniforme en la parte inferior */
            border: 1px solid #ccc; /* Borde estandarizado */
            border-radius: 3px; /* Bordes redondeados ligeramente */
            box-sizing: border-box; /* Incluye padding y bordes en el ancho total del elemento */
           }
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 3px;
            background-color: #8ec8ee;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
        .login-container input[type="submit"]:hover {
            background-color: #6eb4e7;
        }
        .login-container p {
            text-align: center;
            font-size: 0.9em;
        }
        .login-container a {
            color: #0095f6;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        .rotulo{
        /*background-color: #EFEFEF; */
        border-radius: 9px 9px 0px 0px;
        padding: 3px;
        text-align: center;
        font-size: 20px;
        
        }

        /* El Botón Close (x) */
        .close {
            color: black;
            float: right;
            font-size: 20px;
            font-weight: bold;
            padding: 7px;
        
        }
        .registro {
        color: red;
        display: none; 
        font-size: 0.9em; 
        margin-top: 5px; 
        }
   
    </style>
</head>
<body>
    <div class="login-container">
        <div class="rotulo">
            <a href="Index.php">
            <span class="close">&times;</span></a>
            <h2>Inicio de sesión</h2>
        </div> 
        <form method="post" action="login.php">
            <input type="text" id="username" name="username" placeholder="Nombre de usuario" required>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <input type="submit" value="Iniciar sesión">
            <?php if (!empty($_SESSION['resultadoRegistro'])): ?>
        <span id="resultadoRegistro" class="registro" style="display: block;">
            <?php echo $_SESSION['resultadoRegistro']; ?>
        </span>
            <?php unset($_SESSION['resultadoRegistro']); // Limpia la variable de sesión después de mostrarla ?>
            <?php endif; ?>
            <p><a href="#">¿Olvidaste tu contraseña?</a></p>
            <p>¿No tienes una cuenta? Regístrate como <a href="formularioFan.php">fan</a> o <a href="FormArtista.php">artista.</a></p>
        </form>
    </div>
</body>
</html>
<?php

// Manejo del formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_usuario = $_POST['username'];
    $contraseña_ingresada = $_POST['password'];

    $host = 'localhost'; // Asume localhost como host
    $usuario = 'root'; // Usuario de la base de datos
    $nombre_base_datos = 'BaseMusicas'; // Nombre de la base de datos

    // Crear conexión
    $con =  mysqli_connect($host, $usuario, '', $nombre_base_datos) or die("Problemas con la conexión a la base de datos"); 

    // Establecer la codificación de caracteres a UTF-8
    mysqli_set_charset($con, "utf8");

    // Consulta para obtener el hash de la contraseña y el UsuarioID
    $sql = "SELECT UsuarioID, ContraseñaHash FROM Usuarios WHERE NombreUsuario = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $nom_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    

    // Verifica que el usuario exista
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hash_guardado = $row['ContraseñaHash'];
        $usuario_id = $row['UsuarioID'];
        
        // Verifica la contraseña
        if (password_verify($contraseña_ingresada, $hash_guardado)) {
            $sqlArtista = "SELECT ArtistaID, Nombre FROM Artistas WHERE UsuarioID = ?";
            $stmtArtista = $con->prepare($sqlArtista);
            $stmtArtista->bind_param("i", $usuario_id);
            $stmtArtista->execute();
            $result = $stmtArtista->get_result();
            if ($row = $result->fetch_assoc()) {
                $_SESSION['IDartista'] = $row['ArtistaID'];
                $_SESSION['Artista'] = $row['Nombre'];

            }
            $stmtArtista->close();

            // Si la contraseña es correcta, guarda el nombre de usuario y UsuarioID en la sesión
            $_SESSION['usuario'] = $nom_usuario;
            $_SESSION['IDusuario'] = $usuario_id;
          // Guardar UsuarioID en la sesión
            header("Location: Index.php");
            exit;
        } else {
            $_SESSION['resultadoRegistro'] = "Contraseña incorrecta.";
        }
    } else {
        $_SESSION['resultadoRegistro'] = "No se encontró el usuario.";
    }

    // Cierra la declaración preparada y la conexión
    $stmt->close();
    $con->close();
    header("Location: Index.html");
}
?>

 

