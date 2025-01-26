<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica si el parámetro de logout está presente en la URL
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    session_destroy();
    header("Location: Index.php");
    exit;
}

if (isset($_POST['delete'])) {
    $index = $_POST['cancionIndex'];  // Recibe el índice de la canción a eliminar
    if (is_numeric($index) && isset($_SESSION['canciones'][$index])) {
        unset($_SESSION['canciones'][$index]);  // Elimina la canción específica
        $_SESSION['canciones'] = array_values($_SESSION['canciones']);  // Reindexa el array después de la eliminación
        $message = "Canción eliminada correctamente.";
    } else {
        $message = "No se encontró la canción a eliminar.";
    }
    // Redirige y muestra un mensaje opcionalmente
    header("Location: FormularioAñadirMusica.php?mensaje=" . urlencode($message));
    exit;
}
?>
