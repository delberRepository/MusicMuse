<?php session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    // Elimina la variable de sesión 'usuario'
    unset($_SESSION['usuario']);
    unset($_SESSION['canciones']);
    
    // Opcional: Destruye la sesión completa
    session_destroy();
    
    // Redirige al usuario a la página de inicio o de inicio de sesión
    header("Location: Index.php");
    exit;
}


$host = 'localhost'; // Cambiar por tu host
$usuario = 'root'; // Cambiar por tu usuario de la base de datos
$nombre_base_datos = 'BaseMusicas'; // Cambiar por el nombre de tu base de datos

// Crear conexión
$con = mysqli_connect($host, $usuario, '', $nombre_base_datos) or die("Problemas con la conexión a la base de datos"); 

// Establecer la codificación de caracteres a UTF-8
mysqli_set_charset($con, "utf8");




            // Datos del álbum y artista
        $album = $_SESSION['albumName'];
        $fecha = $_SESSION['releaseDate'];
        $genero = $_SESSION['Genero'];
        $info = $_SESSION['infoDisco'];
        $creditos = $_SESSION['Creditos'];
        $portada = $_SESSION['caratula'];
        $pais =  $_SESSION['Etiquetas'];
        $usuarioID = $_SESSION['IDusuario']; // ID del usuario en sesión
        $artistaID=  $_SESSION['IDartista'];// ID del artista en sesión

        /* Insertar en la tabla Artista
        $sqlArtista = "INSERT INTO Artistas (Nombre, Pais, UsuarioID) VALUES (?, ?, ?)";
        $stmtArtista = $con->prepare($sqlArtista);
        $stmtArtista->bind_param("ssi", $artista, $pais, $usuarioID);
        $stmtArtista->execute();
        //$artistaID = $con->insert_id; // Captura el ID generado para el artista
        $stmtArtista->close();*/

        // Insertar en la tabla Discos
        $sqlAlbum = "INSERT INTO Discos (Titulo, Genero, FechaLanzamiento, ImagenPortada, ArtistaID) VALUES (?, ?, ?, ?, ?)";
        $stmtAlbum = $con->prepare($sqlAlbum);
        $stmtAlbum->bind_param("ssssi", $album, $genero, $fecha, $portada, $artistaID);
        $stmtAlbum->execute();
        $discoID = $con->insert_id; // Captura el ID generado para el disco
        $stmtAlbum->close();

        // Insertar en la tabla Canciones
        if (isset($_SESSION['canciones']) && !empty($_SESSION['canciones'])) {
            $sqlCancion = "INSERT INTO Canciones (Titulo, Duracion, DiscoID) VALUES (?, ?, ?)";
            $stmtCancion = $con->prepare($sqlCancion);
            foreach ($_SESSION['canciones'] as $cancion) {
                $stmtCancion->bind_param("ssi", $cancion['nombre'], $cancion['duracion'], $discoID);
                $stmtCancion->execute();
            }
            $stmtCancion->close();
        }

        if (isset($_SESSION['canciones']) && !empty($_SESSION['canciones'])) {
            $sqlArchivo = "INSERT INTO archivos_musica (nombre_archivo, nombre_audio, DiscoID) VALUES (?, ?, ?)";
            $stmtArchivo= $con->prepare($sqlArchivo);
            foreach ($_SESSION['canciones'] as $cancion) {
                $stmtArchivo->bind_param("ssi", $cancion['archivo'], $cancion['reproNom'],$discoID);
                $stmtArchivo->execute();
            }
            $stmtArchivo->close();
        }


        $con->close();

        echo "Datos cargados con exito";
        header("Location: Index.php");
        exit;
        

        //solo me falta cargar los archivos de musica en la baseDatosl`+
        
    
?>

