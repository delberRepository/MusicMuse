<?php session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    
       // Asegúrate de que la sesión esté iniciada
	   
	   // Verifica si el parámetro de logout está presente en la URL
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
       if (isset($_POST['submit'])) {
        // Asumiendo que 'submit' es el botón para subir el formulario completo
        $_SESSION['albumName'] = $_POST['albumName'];
        $_SESSION['releaseDate'] = $_POST['releaseDate'];
        $_SESSION['Genero'] = $_POST['Genero'];
        $_SESSION['infoDisco'] = $_POST['infoDisco'];
        $_SESSION['Creditos'] = $_POST['Creditos'];
        $_SESSION['formularioEnviado'] = true;
        
       
        // etc. para otros campos
    }
  
    
    
       
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
            color:white;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: trasparent;
            padding: 20px;
            border-radius:4px;
            
        }

        .upload-section {
            display: flex;
            flex-direction: column;
            margin-left:350px;
        }

        .form-group {
            margin-bottom: 10px;
            color:white;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="file"] {
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




<div class="totalNav">
	
        <nav>
            <ul >
                <?php if (isset($_SESSION['usuario'])): ?>
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
 </div>
	
	

    <!-- SUBIR MUSICA -->
            <div id="ventana2" class="ventana">
                    <div class="contenidoVentana">
                       <div class="rotulo"> 
                     
                        <span class="close2">&times;</span>
                        <p>MUSEMUSICA</p>
                       </div>       
                       
                       <div class="orden"> 
                       <form action="FormularioAñadirMusica.php" method="post" enctype="multipart/form-data">

                        
                            <div class="form-group">
                                <label for="Name">Nombre canción</label>
                                <input type="text" id="Name" name="Name" >
                                <input type="hidden" id="indice" name="indice" value=" " >
                                
                            </div> 
                                   <br>
                            <div class="form-group">
                                <label for="colaboracion">Colaboraciones</label>
                                <input type="text" id="colaboracion" name="colaboracion" placeholder="(opcional)">
                            </div> 

                           <!-- <div class="form-group">
                                <label for="genero">Genero</label>
                                <input type="text" id="genero" name="genero" placeholder="(opcional)" >
                            </div> -->

                            <div class="form-group">
                                <label for="archivoMusica">Selecciona archivo</label>
                                <input type="file" id="archivoMusica" name="archivoMusica">
                            </div> 
                            <div class="form-actions">
                                <input type="submit" value="Subir Archivo" name="submit1">
                            </div> 
                       </form>     
                       </div>   
                    </div>
            </div>
            <?php
       
         /*   TODO ESTE CODIGO ES PARA PODER CARGAR LOS ARCHIVOS EN LAS CARPETAS DE BASE DE DATOS DEL SERVIDOR
            $directorioDestino = "discos/"; // Asegúrate de que este directorio existe y tiene permisos adecuados
           
            $nombreCancion = preg_replace('/[^A-Za-z0-9 ]/', '', $_POST['Name']); // Limpia el nombre de la canción
            $nombreArtista = preg_replace('/[^A-Za-z0-9 ]/', '', $_POST['artista']); // Limpia el nombre del artista
            $tipoArchivoOriginal = strtolower(pathinfo($_FILES["archivoMusica"]["name"], PATHINFO_EXTENSION)); // Obtiene la extensión del archivo original
        
            // Verifica errores
            if ($_FILES["archivoMusica"]["error"] !== UPLOAD_ERR_OK) {
                echo "Error al cargar el archivo.";
                exit;
            }
        
            // Verifica el tipo de archivo
            if (!in_array($tipoArchivoOriginal, ["wav", "aif", "flac"])) {
                echo "Solo se permiten archivos .wav, .aif o .flac.";
                exit;
            }
        
            $archivoFinal = $nombreArtista . " - " . $nombreCancion . "." . $tipoArchivoOriginal; // Forma el nombre del archivo final, incluyendo la extensión
            $rutaArchivoFinal = $directorioDestino . $archivoFinal; // Construye la ruta completa del archivo final
        
            // Intenta subir el archivo
            if (move_uploaded_file($_FILES["archivoMusica"]["tmp_name"], $rutaArchivoFinal)) {
                echo "Archivo subido";
                
                 } else {
                echo "Hubo un error.";
            }
        }*/
        
                // Almacenar información de la canción en la sesión
                
                require_once 'getid3/vendor/autoload.php';
                require_once('getid3/getid3.php');
                if (!class_exists('getID3')) {
                    die('getID3 library is missing!');
                }

                if (isset($_POST["submit1"])) {
                    $directorioDestino = "discos/";
                    $nombreArchivo = $_FILES['archivoMusica']['name'];
                    $rutaTemporal = $_FILES['archivoMusica']['tmp_name'];
                    $rutaDestino = $directorioDestino . basename($nombreArchivo);
                    $nombreAudio = $_SESSION['Artista'] . " - " . $_POST['Name'];
                
                    $index = $_POST['indice']; // Asegúrate de que este valor se envía correctamente desde el formulario
                
                    // Verifica si la canción se está actualizando o es una nueva entrada
                    if ($index !== "" && is_numeric($index)) {
                        // Intenta mover el archivo al directorio destino
                        

                        
                        if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                            $getID3 = new getID3;
                            $fileInfo = $getID3->analyze($rutaDestino);
                            $duracionSegundos = $fileInfo['playtime_seconds'];
                
                            $minutos = floor($duracionSegundos / 60);
                            $segundos = round($duracionSegundos % 60);
                            $duracionFormateada = sprintf('%d:%02d', $minutos, $segundos);
                
                            // Actualiza la entrada existente
                            $_SESSION['canciones'][$index] = [
                                'colaboracion' => $_POST['colaboracion'],
                                'nombre' => $_POST['Name'],
                                'genero' => $_POST['genero'],
                                'archivo' => $nombreArchivo,
                                'ruta' => $rutaDestino,
                                'reproNom' => $nombreAudio,
                                'duracion' => $duracionFormateada
                            ];
                            echo "<script>window.onload = function() { window.location.href = 'FormularioAñadirMusica.php'; }</script>";
                        } else {
                            echo "Hubo un error subiendo el archivo.";
                        }
                    } else {
                        // Manejo de errores o lógica adicional para nueva entrada
                    }
                }
            ?>

      
<div class="contenedorAB">	 
	  <aside>
			<div class="caja1"> 
			  <div class="tuMusica" >	
				 <div class="iconos">	
                    <a href="Index.php">	
                     <i class="bi bi-houses-fill"></i>
                    </a>  
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
			 <?php if (isset($_SESSION['usuario'])&& !$_SESSION['rol'] ): ?>
				<div class="iconos">	
				<a href="miEspacio.php"><i class="bi bi-cassette-fill"></i></a>
				</div>
			 </div>		
			 <div class="tuMusica" > 
				<div class="iconos">	
				<a href="EditarPerfil.php"> <i class="bi bi-gear-wide"></i></a>
				</div>
			 </div>		
			 <div class="tuMusica" > 
				<div class="iconos">	
				<a href="FormularioAñadirMusica.php"><i class="bi bi-cloud-plus"></i></a>
				</div>
			  	
              <?php endif; ?>	
			  <!--<p>Tu Música</p>	--> 
			 </div>	
			 <div >
			 <div>
			 <?php if (isset($_SESSION['usuario'])&& $_SESSION['rol'] ): ?>
				<div class="iconos">	
				<a href="EditarPerfil.php"> <i class="bi bi-gear-wide"></i></a>
				</div>
			 </div>			
              <?php endif; ?>	
			  <!--<p>Tu Música</p>	--> 
			 </div>	  
			 
			 
			

			
		
		</aside>
		<section> 
		 
         

                <div class="container">
                    <div class="upload-section">
                    <form action="Guardar.php" method="post" enctype="multipart/form-data">  
                    <?php if (isset($_SESSION['albumName'])): ?>
                        <h2><?php echo $_SESSION['albumName']; ?></h2>
                    <?php else: ?>
                        <h2>Album sin titulo</h2>
                     <?php endif; ?>
                        <div class="form-group">
                            <label for="albumName">Nombre disco</label>
                            <input type="text" id="albumName" name="albumName" style="width: 240px" placeholder="nombre disco"
                            value="<?php echo isset($_SESSION['albumName']) ? htmlspecialchars($_SESSION['albumName']) : ''; ?>">

                              
                        </div>
                        <div class="form-group">
                            <label for="releaseDate">Fecha lanzamiento</label>
                            <input type="text" id="releaseDate" name="releaseDate" style="width: 240px"  placeholder="yyyy/mm/dd"
                            value="<?php echo isset($_SESSION['releaseDate']) ? htmlspecialchars($_SESSION['releaseDate']) : ''; ?>">
                        </div>
                       <!-- <div class="form-group">
                            <label for="artistaco">Artista</label>
                            <input type="text" id="artistaco" name="Artista" style="width: 240px"  placeholder="artista"
                            value="<?//php echo isset($_SESSION['Artista']) ? htmlspecialchars($_SESSION['Artista']) : ''; ?>">
                        </div>-->
                        <div class="form-group">
                            <label for="genero">Genero</label>
                            <input type="text" id="genero" name="Genero" style="width: 240px"  placeholder="genero"
                            value="<?php echo isset($_SESSION['Genero']) ? htmlspecialchars($_SESSION['Genero']) : ''; ?>">
                        </div>
                        <!--
                        <div class="form-group">
                            <label for="etiquetas">Pais</label>
                            <input type="text" id="etiquetas" name="Etiquetas" placeholder="Pais" style="width: 200px"
                            value="<?//php echo isset($_SESSION['Etiquetas']) ? htmlspecialchars($_SESSION['Etiquetas']) : ''; ?>" >
                        </div> -->
                    

                        <div class="form-group">
                            <label for="infoDisco">Información sobre el disco</label>
                            <input type="text" id="infoDisco" name="infoDisco" style="width: 240px"  placeholder="(opcional)"
                            value="<?php echo isset($_SESSION['infoDisco']) ? htmlspecialchars($_SESSION['infoDisco']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="creditos">Creditos</label>
                            <input type="text" id="creditos" name="Creditos" style="width: 240px"  placeholder="(opcional)"
                            value="<?php echo isset($_SESSION['Creditos']) ? htmlspecialchars($_SESSION['Creditos']) : ''; ?>">
                        </div>



                         <div class="form-group">
                            <label for="albumArt">Subir portada disco <b>(jpg o png)</b></label>
                            <input type="file" id="albumArt" name="albumArt" style="width: 400px" ><br>
                        </div>
                        <div class="form-actions">
                            <button type="submit"  name="submit" id="submitPreview">Guardar</button>
                            <a href="limpiarformulario.php"> <p class="cancelar">Cancelar</p></a>
                        </div>   
                        </form>   


                            
                            <!--AQUI SOLO SE MUESTRA LA PORTADA EN CASO DE QUE EXISTA LA VARIABLE-->
                            <?php if (isset($_SESSION['caratula'])): ?>
                             <img src="portadas/<?php echo $_SESSION["caratula"];?>" alt="Nombre del Álbum" style="max-width:400px;">
                             <?php endif;?>
                            
     
                   

                    <div class="form-actions">
                            <button type="button"  id="openVentana2">Añadir canción</button>
                            <p id="añadir" style="border-style: solid; border-color:white; width: 300px"> 300MB max por canción .wav, .aif o .flac</p>
                        </div>
                        <?php
                            if (isset($_SESSION['canciones']) && count($_SESSION['canciones']) > 0) {
                                echo '<table class="tablalistado">';
                                echo '<tr><th>Pista</th><th>Canción</th><th>Colaboraciones</th><th>Duración</th><th>Editar</th><th>Borrar</th></tr>';
                                $id = 1;
                                foreach ($_SESSION['canciones'] as $index => $cancion) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($id) . '</td>';
                                    echo '<td>' . htmlspecialchars($cancion['nombre']) . '</td>';
                                    echo '<td>' . htmlspecialchars($cancion['colaboracion'] ?? 'No disponible') . '</td>';
                                    echo '<td>' . htmlspecialchars($cancion['duracion']) . '</td>';
                                    echo '<td><button class="openVentana3" data-index="' . $index . '" data-nombre="' . htmlspecialchars($cancion['nombre']) .
                                     '" data-colaboracion="' . htmlspecialchars($cancion['colaboracion'] ?? '') . '">Editar</button></td>';
                                    echo '<td><form action="eliminarCancion.php" method="post">
                                              <input type="hidden" name="cancionIndex" value="' . $index . '">
                                              <button type="submit" name="delete">Eliminar</button>
                                          </form></td>';
                                    echo '</tr>';
                                    $id++;
                                }
                                
                                
                                
                                echo '</table>';
                            }
                            
                            ?>



                       
                    
                        <!-- aqui se va a mostrar el buton publicar en cuanto se cree la variable de sesion [canciones]-->
                        <?php if(isset($_SESSION['canciones'])): ?>
                                <div class="form-actions">
                                    <a href="CargarBaseDatos.php"><button type="button" >Publicar</button></a>
                                </div> 
                                <div class="form-actions">
                                    <a href="vistaPrevia.php"><button type="button" id="previsualizar">Previsualizar</button></a>
                                </div>
                                <?php endif; ?>    


                            <!-- En FormularioAñadirMusica.php dentro del HTML donde deseas los botones -->
                        
                                
                                
                            

                           
                        </div>
                       
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
                var indiceInput = document.getElementById('indice'); // Obtiene el input donde se debe colocar el índice
                var span2 = document.querySelector('.close2'); // Asegúrate de que esta clase exista en tu botón de cerrar del segundo modal

                if (btn2 && ventana2 && span2 && indiceInput) {
                    btn2.onclick = function() {
                        ventana2.style.display = 'block';
                        // Establece el valor del input 'indice' al siguiente índice disponible en el array de PHP
                        <?php
                            // Comprueba si el array 'canciones' existe y calcula el siguiente índice
                            if (isset($_SESSION['canciones'])) {
                                echo "indiceInput.value = " . count($_SESSION['canciones']) . ";";
                            } else {
                                echo "indiceInput.value = 0;"; // Si no hay canciones, el índice inicial es 0
                            }
                        ?>
                    }

                    span2.onclick = function() {
                        ventana2.style.display = 'none';
                    }
                }

                
                    var btn3 = document.getElementsByClassName('openVentana3');
                    var ventana3 = document.getElementById('ventana2');
                    var span3 = document.querySelector('.close2');

                    if (ventana3 && span3) {
                        span3.onclick = function() {
                            ventana3.style.display = 'none';
                        };
                    }

                    Array.from(btn3).forEach(function(button) {
                        button.onclick = function() {
                            ventana3.style.display = 'block';

                            // Obtener los datos
                            var nombre = this.getAttribute('data-nombre');
                            var colaboracion = this.getAttribute('data-colaboracion');
                            var index=this.getAttribute('data-index');
                    
                            // Cargar los datos en el modal
                            document.getElementById('Name').value = nombre;
                            document.getElementById('colaboracion').value = colaboracion;
                            document.getElementById('indice').value = index;
                           
                        };
                    });
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


            //CODIGO PARA PRECARGAR LA IMAGEN EN LA WEB
            document.addEventListener('DOMContentLoaded', function() {
                    // Intentar recuperar y mostrar la imagen al cargar la página
                    var storedImage = localStorage.getItem('savedImage');
                    if (storedImage) {
                        var container = document.getElementById('previewContainer');
                        var imgElement = document.createElement('img');
                        imgElement.style.maxWidth = '300px';
                        imgElement.style.maxHeight = '300px';
                        imgElement.src = storedImage;
                        container.innerHTML = ''; // Limpiar el contenedor primero
                        container.appendChild(imgElement);
                    }

                    document.getElementById('albumArt').addEventListener('change', function(event) {
                        var file = event.target.files[0];
                        if (file) {
                            if (/^(image\/jpeg|image\/png)$/i.test(file.type)) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    var imgElement = document.createElement('img');
                                    imgElement.style.maxWidth = '300px';
                                    imgElement.style.maxHeight = '300px';
                                    imgElement.src = e.target.result;
                                    var container = document.getElementById('previewContainer');
                                    container.innerHTML = '';
                                    container.appendChild(imgElement);

                                    // Guardar la imagen en localStorage
                                    localStorage.setItem('savedImage', e.target.result);
                                };
                                reader.readAsDataURL(file);
                            } else {
                                alert('El archivo debe ser una imagen en formato jpg o png.');
                            }
                        }
                    });
                });



                      /*  function displayImage(base64Image, container) {
                            if (container) {
                                container.innerHTML = ''; // Limpiar el contenedor primero
                                var imgElement = document.createElement('img');
                                imgElement.style.maxWidth = '300px';
                                imgElement.style.maxHeight = '300px';
                                imgElement.src = base64Image;
                                container.appendChild(imgElement);
                            }
                        }
*/





  

	</script>

		

</body> 

</html>
