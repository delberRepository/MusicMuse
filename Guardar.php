<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {
        $directorioDestino = "portadas/"; 
        $nombreDisco = preg_replace('/[^A-Za-z0-9 ]/', '', $_POST['albumName']); // Limpia el nombre del disco
        $nombreArtista = preg_replace('/[^A-Za-z0-9 ]/', '',  $_SESSION['Artista']); // Limpia el nombre del artista
        $tipoArchivoOriginal = strtolower(pathinfo($_FILES["albumArt"]["name"], PATHINFO_EXTENSION)); // Obtiene la extensión del archivo original
        
        // Verifica errores
        if ($_FILES["albumArt"]["error"] !== UPLOAD_ERR_OK) {
            echo "Error al cargar el archivo.";
            exit;
        }
    
        // Verifica el tipo de archivo
        if (!in_array($tipoArchivoOriginal, ["jpg", "png"])) {
            echo "Solo se permiten archivos .jpg o .png";
            exit;
        }
    
        $archivoFinal = $nombreArtista . "-" . $nombreDisco . "." . $tipoArchivoOriginal; // Forma el nombre del archivo final
        $rutaArchivoFinal = $directorioDestino . $archivoFinal; // Construye la ruta completa del archivo final
        $_SESSION['caratula'] = $archivoFinal; // Almacena carátula en variable de sesión
    
        // Intenta subir el archivo
        if (!move_uploaded_file($_FILES["albumArt"]["tmp_name"], $rutaArchivoFinal)) {
            echo "Hubo un error al subir el archivo.";
            exit;
        }
    }

    if (isset($_POST['albumName']) && !empty($_POST['albumName']) && 
        isset($_POST['releaseDate']) && !empty($_POST['releaseDate'])
        && isset($_POST['Genero']) && !empty($_POST['Genero'])) {
      
        // Almacenamiento de los datos del formulario en variables de sesión
        $_SESSION['albumName'] = $_POST['albumName'];
        $_SESSION['releaseDate'] = $_POST['releaseDate'];
        $_SESSION['Genero'] = $_POST['Genero'];
        $_SESSION['infoDisco'] = $_POST['infoDisco'];
        $_SESSION['Creditos'] = $_POST['Creditos'];
        $_SESSION['Etiquetas'] = $_POST['Etiquetas'];
        $_SESSION['albumArt'] = $_POST['albumArt'];
        $_SESSION['formularioEnviado'] = true;

        // Redirección a FormularioAñadirMusica.php
        header("Location: FormularioAñadirMusica.php");
        exit;
    } else {
        echo "Por favor, rellene todos los campos antes del envio";
    }
}
?>
