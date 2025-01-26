<?php 
            session_start();
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            // Configuración de la conexión a la base de datos
            $host = 'localhost';
            $usuario = 'root';
            $nombre_base_datos = 'BaseMusicas';
            $conn = new mysqli($host, $usuario, "", $nombre_base_datos);
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
            mysqli_set_charset($conn, "utf8");

            // Verifica si el parámetro de logout está presente en la URL
            if (isset($_GET['logout']) && $_GET['logout'] == 1) {
                session_destroy();
                header("Location: Index.php");
                exit;
            }
            //Este se manejara si se viene de eliminar perfil
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'deleted') {
                    $mensaje = "Perfil borrado.";
                } else {
                    $mensaje = "Error al borrar el perfil.";
                }
            } else {
                $mensaje = "";
            }

            // Inicializa variables
            $nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
            $correo = '';
            $contrasena = '';
            $ID = '';
            $artista = '';
            $descripcion = '';

            // Si el método es POST, procesa el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nombreUsuario = $_POST['usuario'] ?? $nombreUsuario; // Usar el nuevo nombre de usuario si está disponible
                $correo = $_POST['correo'] ?? '';
                $descripcion = $_POST['descripcion'] ?? '';
                $artista = $_POST['artista'] ?? '';

                // Actualizar datos de usuario
                $sql = "UPDATE Usuarios 
                           SET Correo = ?, NombreUsuario = ?
                         WHERE NombreUsuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $correo, $nombreUsuario, $_SESSION['usuario']);
                if (!$stmt->execute()) {
                    die('Error al actualizar el usuario: ' . $stmt->error);
                }
                $stmt->close();

                // Obtener el ID de usuario para usarlo en la actualización del artista
                $sql = "SELECT UsuarioID 
                          FROM Usuarios
                         WHERE NombreUsuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $nombreUsuario);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $ID = $row['UsuarioID'];
                }
                $stmt->close();

                // Actualizar datos del artista
                $sql = "UPDATE Artistas 
                           SET Nombre = ?, Descripcion = ? 
                         WHERE UsuarioID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $artista, $descripcion, $ID);
                if (!$stmt->execute()) {
                    die('Error al actualizar el artista: ' . $stmt->error);
                }
                $stmt->close();


                $sql = "SELECT Titulo ImagenPortada
                        FROM Discos
                        WHERE ArtistaID IN (SELECT ArtistaID FROM Usuarios WHERE UsuarioID = ?);";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $ID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $Discos = $row['Titulo'];
                    $Discos = $row['ImagenPortada'];
                }
                $stmt->close();


                $_SESSION['usuario'] = $nombreUsuario; // Actualizar la sesión con el nuevo nombre de usuario
                //echo "Cambio realizado!";
            }


            // Si el método no es POST, obtén los datos del usuario
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                $sql = "SELECT Correo, ContraseñaHash, UsuarioID 
                          FROM Usuarios
                         WHERE NombreUsuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $nombreUsuario);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $correo = $row['Correo'];
                    $contrasena = $row['ContraseñaHash'];
                    $ID = $row['UsuarioID'];
                }
                $stmt->close();

                // Obtener nombre y descripción del artista
                $sql = "SELECT Nombre, Descripcion
                          FROM Artistas 
                         WHERE UsuarioID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $ID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $artista = $row['Nombre'];
                    $descripcion = $row['Descripcion'];
                }
                $stmt->close();
            }

            $conn->close(); // Cerrar la conexión a la base de datos
            ?>


<!DOCTYPE html>
<html lang="es">  
<head>    
    <title>Formulario de Subida de Música</title>    
    <meta charset="UTF-8">

   <style>
       body{
        background-color: #000000;           }
        .cancelar{
            color: #000 !important;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #d4d4d4;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius:4px;
            
        }

        .upload-section {
            display: flex;
            flex-direction: column;
            margin-left:350px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group input[type="password"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
           
        }

        .form-group input[type="checkbox"] {
            margin-right: 5px;
        }

        .form-actions {
            margin-top: 20px;
        }

        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #333;
            color: white;
            cursor: pointer;
        }

        .form-actions button[type="button"] {
            background: rgb(128, 199, 250);
        }
        #previsualizar{
            background-color: #777; 
        }
        #añadir{
            color: black;
    
        }
        .tablalistado {
        border-collapse: collapse;
        box-shadow: 0px 0px 8px #000;
        margin:20px 0px;
        }
        .tablalistado th{  
            border: 1px solid #000;
            padding: 5px;
            background-color:rgb(180, 180, 180)	  
        }  
        .tablalistado td{  
            border: 1px solid #000;
            padding: 5px;
            background-color:rgb(180, 180, 180);
	  
        }
        

        /* Ajusta los colores, márgenes y otros estilos según tus necesidades */

   </style>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    
    <link href="estiloForm.css" rel="stylesheet" type="text/css"> 
</head>  
<body>


 <div class="container-fluid">


	
 <nav>
    <ul >
    <?php if (isset($_SESSION['usuario'])&& !$_SESSION['rol'] ): ?>
            <li class="nav-item">
                <?= "Hola ".htmlspecialchars($_SESSION['usuario']) ."!"; ?>
                <ul class="dropdown-content">
				<li ><a href="FormularioAñadirMusica.php">Subir Música</a></li>
				<li ><a href="miEspacio.php">Mi espacio</a></li>
				<li><a href="EditarPerfil.php">Editar perfil</a></li>	
				<li><a href="?logout=1">Cerrar Sesión</a></li>

                    <!-- Agrega más enlaces aquí si necesitas -->
                </ul>
            </li>
			<?php  elseif (isset($_SESSION['usuario'])&& $_SESSION['rol'] ): ?>
            <li class="nav-item">
                <?= "Hola ".htmlspecialchars($_SESSION['usuario']) ."!"; ?>
                <ul class="dropdown-content">
				<li><a href="EditarPerfil.php">Editar perfil</a></li>	
				<li><a href="?logout=1">Cerrar Sesión</a></li>

                    <!-- Agrega más enlaces aquí si necesitas -->
                </ul>
            </li>
        <?php else: ?>
            <li class="nav-item" id="openVentana1">
                Registrarse
            </li>
			<a href="login.php">
            <li class="nav-item">
                Iniciar Sesión
            </li>
			</a>
        <?php endif; ?>
    </ul>
</nav>
	
	
    <div class="contenedorAB">	 
    <aside id="aside">
			<div class="caja1"> 
			  <div class="tuMusica" >	
               <div class="iconos">	
                 <a href="index.php"> <i class="bi bi-houses-fill"></i></a>
				 </div>	
				 <!--<p>Inicio</p>-->
			  </div>	
			  <div class="tuMusica" id="searchButton">
				<div class="iconos" >	
				<i class="bi bi-search"></i>
				</div>	
				<!--<p>Buscar</p>-->	
			  </div>
			 
			</div>
			<div class="caja2">
			 <div class="tuMusica">
             <?php if (!$_SESSION['rol']): ?> 
			  <div class="iconos">	
			  <a href="miEspacio.php"><i class="bi bi-cassette-fill"></i></a>
			  </div>	
              <?php endif; ?>
			  <!--<p>Tu Música</p>	--> 
			 </div>	 
			 
			
			 <!--<div id="botones">
				<div class="btn-group" role="group" aria-label="Basic example">
				  <button type="button" class="btn btn-secondary">Bandas</button>
				  <button type="button" class="btn btn-secondary">Records</button>
				  <button type="button" class="btn btn-secondary">Listas</button>
				</div>
			 </div>-->
				
			</div> 
		
		</aside>
		<section> 


                <div class="container">
                    <div class="upload-section">
                    <form action="EditarPerfil.php" method="post" enctype="multipart/form-data">  
                    <p><?php  if ($_SERVER["REQUEST_METHOD"] == "POST") {echo strtoupper('Cambio realizado!');}
                     else if (isset($_GET['status'])){echo strtoupper(($_GET['status']));}?></p>
                        <div class="form-group">
                            <label for="usuario">Nombre de Usuario</label>
                            <input type="text" id="usuario" name="usuario" style="width: 240px" placeholder="nombre disco"
                            value="<?php  if ($_SERVER["REQUEST_METHOD"] == "POST") {echo $_POST['usuario'];}else echo $nombreUsuario ; ?>">

                              
                        </div>
                        <!--este campo solo aparecera en caso de que el usuario sea artista-->
                       <?php if (!$_SESSION['rol']): ?>
                        <div class="form-group">
                            <label for="artista">Nombre Artista</label>
                            <input type="text" id="artista" name="artista" style="width: 240px"  placeholder="artista"
                            value="<?php  if ($_SERVER["REQUEST_METHOD"] == "POST") {echo $_POST['artista'];}else echo $artista ; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="text" id="correo" name="correo" style="width: 240px"  placeholder="correo"
                            value="<?php  if ($_SERVER["REQUEST_METHOD"] == "POST") {echo $_POST['correo'];}else echo $correo ; ?>">
                        </div>
                       <!-- <div class="form-group">
                            <label for="artistaco">Artista</label>
                            <input type="text" id="artistaco" name="Artista" style="width: 240px"  placeholder="artista"
                            value="<?//php echo isset($_SESSION['Artista']) ? htmlspecialchars($_SESSION['Artista']) : ''; ?>">
                        </div>-->
                      
                        
                        <?php if (!$_SESSION['rol']): ?>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" placeholder="Descripción" 
                            style="width: 240px; height: 100px;"><?php  if ($_SERVER["REQUEST_METHOD"] == "POST") {echo $_POST['descripcion'];}else echo $descripcion ; ?></textarea>
                        </div>
                        <?php endif; ?>




                        
                        
                        <div class="form-actions">
                            <button type="submit"  name="submit" id="submitPreview">Guardar</button>
                            
                        </div> 
                           
                        </div>
                       </form>  
                       
                    </div>
                </div>




         
		</section>
		
	</div> 	
		<footer>	
	  </footer>
</div>   
	<script type="text/javascript">

	
	
		var searchButton = document.getElementById('searchButton');
		var inputContainer = document.getElementById('inputContainer');

		// Función para añadir el input de texto
		function Buscar() {
		  // Crear el elemento input
		  var input = document.createElement('input');
		  input.type = 'text'; //le digo que tipo de input
		  input.placeholder = '¿Que te apetece ecuchar?';//Y el contenido que ha de tener
		  input.className= 'inputBusqueda';	

		  // Añadir el input al contenedor
		  inputContainer.innerHTML = ''; // Limpiar el contenedor primero
		  inputContainer.appendChild(input);//ahora añado este apendice hijo al final de la cadena
		  
		}

		// Agregar evento click al botón de búsqueda
		searchButton.addEventListener('click', Buscar);


		
       
				
				document.addEventListener('DOMContentLoaded', function () {
  
				var btn1 = document.getElementById('openVentana1');
				var ventana1 = document.getElementById('ventana1');
				var span1 = document.querySelector('.close'); // Si solo hay un botón de cerrar con esta clase

				if (btn1 && ventana1 && span1) {
					btn1.onclick = function() {
						ventana1.style.display = 'block';
					}

					span1.onclick = function() {
						ventana1.style.display = 'none';
					}
				}

				// Repite el proceso para el segundo modal con los IDs y clases correspondientes
				var btn2 = document.getElementById('openVentana2');
				var ventana2 = document.getElementById('ventana2');
				var span2 = document.querySelector('.close2'); // Asegúrate de que esta clase exista en tu botón de cerrar del segundo modal

				if (btn2 && ventana2 && span2) {
					btn2.onclick = function() {
						ventana2.style.display = 'block';
					}

					span2.onclick = function() {
						ventana2.style.display = 'none';
					}
				}
			});
       


        //GUARDAR REGISTROS EN EL CAMPO
        document.addEventListener('DOMContentLoaded', function () {
        var inputElements = document.querySelectorAll('#albumName, #releaseDate,, #genero, #infoDisco, #creditos,#albumArt');

                inputElements.forEach(element => {
                    // Cargar datos guardados
                    if (localStorage.getItem(element.id)) {
                        element.value = localStorage.getItem(element.id);
                    }

                    // Guardar datos cuando cambien
                    element.addEventListener('blur', function() {
                        localStorage.setItem(element.id, element.value);
                    });
                });
            });
                    
                        document.getElementById('submitPreview').addEventListener('click', function() {
                            // Aquí podría ir tu código para manejar el envío real
                            clearLocalStorage();  // Limpia después del envío
                        });
                        //aqui limpio los campos
                        function clearLocalStorage() {
                            localStorage.removeItem('albumName');
                            localStorage.removeItem('releaseDate');
                            localStorage.removeItem('genero');
                            localStorage.removeItem('infoDisco');
                            localStorage.removeItem('creditos');
                         
                            // etc. para otros campos
                        }


            


  

	</script>

		

</body> 

</html>

