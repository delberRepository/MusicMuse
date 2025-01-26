<?php
session_start();

// Verificar si hay una sesión activa
if (isset($_SESSION['usuario'])) {
    // Limpiar la lista de canciones de la sesión
    //y elimino las variables de sesion que me apetece limpiar
    unset($_SESSION['canciones']);
    unset($_SESSION['albumName']); 
    unset($_SESSION['Artista']);
    unset($_SESSION['releaseDate'] );
    unset($_SESSION['Genero']); 
    unset($_SESSION['infoDisco']);
    unset($_SESSION['Genero']); 
    unset($_SESSION['Creditos']); 
    unset($_SESSION['Etiquetas']); 
    unset($_SESSION['albumArt']); 
    unset($_SESSION['caratula']);



    // Redirigir al usuario de regreso a la página principal o donde desees
    header("Location: FormularioAñadirMusica.php");
    exit;
} else {
    // Si no hay sesión activa, redirigir al usuario a la página de login o inicio
    header("Location: login.php");
    exit;
}
?>
