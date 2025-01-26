<?php 
            session_start();
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            // Verifica si el parámetro de logout está presente en la URL
            if (isset($_SESSION['usuario'])) {
                
                $host = 'localhost';
                $usuario = 'root';
                $nombre_base_datos = 'BaseMusicas';
                $conn = new mysqli($host, $usuario, "", $nombre_base_datos);
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                mysqli_set_charset($conn, "utf8");

                //aqui recupero el ID aunque quizas tambien lo tenga almacenado 
                //en una variable de sesion
                $sql = "SELECT UsuarioID 
                          FROM Usuarios
                         WHERE NombreUsuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $_SESSION['usuario']);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $ID = $row['UsuarioID'];
                }
                $stmt->close();

                if (isset($ID)) {
                   //elimino las canciones subidas por este usuario
                    $sql = "DELETE FROM Canciones 
                                  WHERE DiscoID IN (
                                 SELECT DiscoID FROM Discos 
                                  WHERE ArtistaID IN (
                                 SELECT ArtistaID FROM Artistas 
                                  WHERE UsuarioID = ?)
                                    )";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $ID);
                    $stmt->execute();  
                    //elimino los archivos las canciones subidas por este usuario
                    $sql = "DELETE FROM archivos_musica 
                                  WHERE DiscoID IN (
                                 SELECT DiscoID FROM Discos 
                                  WHERE ArtistaID IN (
                                 SELECT ArtistaID FROM Artistas 
                                  WHERE UsuarioID = ?)
                                    )";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $ID);
                    $stmt->execute();      
                    
                    
                  // Eliminar discos del artista
                    $sql ="DELETE FROM Discos 
                                 WHERE ArtistaID IN (
                                SELECT ArtistaID FROM Artistas 
                                WHERE UsuarioID = ?)" ;
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $ID);
                    $stmt->execute();


                    // Eliminar perfil de artista
                    $sql = "DELETE FROM Artistas 
                                  WHERE UsuarioID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $ID);
                    $stmt->execute();
                
                    // Eliminar usuario
                    $sql = "DELETE FROM Usuarios
                                  WHERE UsuarioID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $ID);
                    $stmt->execute();

                    session_destroy();
                    header("Location: EditarPerfil.php?status=Usuario eliminado");
                } else {
                    header("Location: EditarPerfil.php?status=error");
                }
                exit;
            }
 




?>            