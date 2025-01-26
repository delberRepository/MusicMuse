<?php
session_start(); // Iniciar la sesión

// Ejemplo de array de canciones en la sesión
$_SESSION['canciones'] = [
    ['id' => 1, 'name' => 'Canción 1'],
    ['id' => 2, 'name' => 'Canción 2']
];

echo '<table class="tablalistado">';
echo '<tr><th>Editar</th><th>Borrar</th></tr>';

if (isset($_SESSION['canciones']) && count($_SESSION['canciones']) > 0) {
    foreach ($_SESSION['canciones'] as $cancion) {
        echo '<tr>';
        echo '<td><button type="button">Editar</button></td>';
        echo '<td>';
        echo '<form action="index.php" method="post">';
        echo '<input type="hidden" name="song_id" value="' . htmlspecialchars($cancion['id']) . '">';
        echo '<button type="submit" name="delete" value="true">Eliminar</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
}

echo '</table>';
?>
