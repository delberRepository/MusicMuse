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

            //funcion para sumar el tiempo total de las canciones
            function timeToSecond($time) {
                list($hours, $minutes, $seconds) = explode(':', $time);
                return $hours * 3600 + $minutes * 60 + $seconds;
            }

            function secondsToTime($seconds) {
                $hours = floor($seconds / 3600);
                $minutes = floor(($seconds % 3600) / 60);
                $seconds = $seconds % 60;
                return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
            }


            // Configuración de la conexión a la base de datos
            $host = 'localhost';
            $usuario = 'root';
            $nombre_base_datos = 'BaseMusicas';

            // Crear una única conexión
            $conn = new mysqli($host, $usuario, "", $nombre_base_datos);
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
            mysqli_set_charset($conn, "utf8");

            if(isset($_GET['artista_id']) && is_numeric($_GET['artista_id'])) {
                // Recuperar el ID del artista desde la URL
                $IdRecibido = $_GET['artista_id'];

            $sql = "SELECT Nombre, Descripcion
                      FROM Artistas 
                     WHERE ArtistaID = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $IdRecibido);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si se encontró un artista con el ID dado
            if ($result->num_rows > 0) {
                // Obtener el nombre del artista
                $row = $result->fetch_assoc();
                $Nombre = $row['Nombre'];
                $descripcion=$row['Descripcion'];

            } else {
                echo "No se encontró ningún artista con el ID: $IdRecibido";
            }

            $stmt->close();
            } else {
            echo "No se recibió un ID de artista válido.";
            }
      
                    

            

?>


<!DOCTYPE html>
<html lang="es">  
<head>    
    <title>Formulario de Subida de Música</title>    
    <meta charset="UTF-8">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Turret+Road:wght@200;300;400;500;700;800&display=swap" rel="stylesheet">
 

   <style>
       

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
            background-color: green;
        }
        #morlaco{
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
        .header {
            background-color: #181818; /* Elige el color de fondo adecuado */
            color: white;
            padding: 10px;
            display: flex;
            flex-direction: column;
            /*align-items: center;*/
            height: 500px;
            margin: 0px -12px;
        }
        .album-info {
            display: flex;
            padding: 20px;
            align-items: center;
        }
        .atras{
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 30px;

        }
        .album-info img {
            width: 270px; /* Ajusta al tamaño deseado */
            margin-right: 20px;
        }
        .album-details {
             margin-right: auto; /* Empuja los controles de reproducción hacia la derecha */
        
            }
        .album-details h1,
        .album-details p {
            margin: 0; /* Elimina cualquier margen por defecto */
            padding: 0; /* Elimina cualquier padding por defecto */
            color: white;
        }
        .playlist {
            font-family: Arial, sans-serif;
            
            color: white;
            background-color: #181818;
            padding: 20px;
            margin: 0px -12px;
        }
        .playlist-header {
            display: grid;
            grid-template-columns: 0.2fr 2fr 1fr 1fr 0.5fr;
            border-bottom: 1px solid #282828;
            padding-bottom: 5px;
        }
        .song {
            display: grid;
            grid-template-columns: 0.2fr 2fr 1fr 1fr 0.5fr;
            padding: 10px 0;
        }
        .songs {
            display: flex;
            flex-direction: column;
        }
       
        .song:nth-child(even) {
            background-color: #282828;
        }
        .song:hover{
            background-color: rgba(201, 200, 200, 0.3);
            
        }
        .play-button {
            grid-column: 1;
            justify-self: center;
        }
        .title {
            grid-column: 2;
        }
        .artist {
            grid-column: 3;
        }
        .album {
            grid-column: 4;
        }
        .duration {
            grid-column: 5;
            
        }
        img{
            border-radius: 4px;
            width: 300px;
            
        }
        .playplay{
            height: 80px;
        }
        #logoplay{
           
            font-size: 50px;
            color: rgb(41, 236, 41);
            margin-left: 20px;
        }
        .letrasCabecera{
           color: white;
           text-align: center;
           justify-content: center;
           font-size: 90px;
        }
        .borrar_boton{
            border-radius: 17px;
            border: none;
            margin-left: 20px;
        }
       

        /* Ajusta los colores, márgenes y otros estilos según tus necesidades */

   </style>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    
    <link href="estiloPag.css" rel="stylesheet" type="text/css"> 
</head>  
<body>





	
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
	
	
	     
            


<div class="contenedorAB"style="margin-top:-13px;">	 
	  <aside >
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

		 
         <!-- AQUI ES DODNDE ESTA LA INFORMACION GENERAL DEL ARTISTA-->
       

             <div class="container">
                 <div class="header" >
                    <h1 class="letrasCabecera"><?php echo strtoupper($Nombre); ?></h1>
                   <?php echo '<p style="text-align: center;">' . $descripcion . '</p>';?>
                    <div class="atras">
                         <i class="bi bi-rewind-circle-fill"></i>
                        <i class="bi bi-fast-forward-circle-fill"></i>
                    </div>  
                    
    
                    <?php
    

                    $sql = "SELECT DiscoID 
                              FROM Discos 
                              WHERE ArtistaID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $IdRecibido);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $discosID = [];
                    while ($row = $result->fetch_assoc()) {
                        $discosID[] = $row['DiscoID'];
                    }
                    $stmt->close();
                    
                    // Para cada DiscoID, realizar consultas y mostrar información
                    foreach ($discosID as $discoID) {
                        try {
                            // Consulta para obtener canciones del disco
                            $sql = "SELECT Titulo, Duracion 
                                      FROM Canciones 
                                     WHERE DiscoID = ? 
                                     ORDER BY CancionID ASC";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $discoID);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $cancionesNombre = [];
                            $duracion = [];

 
                            while ($row = $result->fetch_assoc()) {
                                $cancionesNombre[] = $row['Titulo'];
                                $duracion[] = $row['Duracion'];
                            }
                            $stmt->close();

                             //aqui llamo a la funcion declarada previamente arriba

                             $duracionTotalSeconds = 0;
                             foreach ($duracion as $time) {
                                 $duracionTotalSeconds += timeToSecond($time);
                             }
                             //aqui llamo a la funcion declarada previamente arriba
                             $duracionTotal = secondsToTime($duracionTotalSeconds);

                    
                            // Consulta para obtener detalles del disco
                            $sql = "SELECT ImagenPortada, FechaLanzamiento, Titulo
                                      FROM Discos 
                                     WHERE DiscoID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $discoID);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($row = $result->fetch_assoc()) {
                                $portada = $row['ImagenPortada'];
                                $fechaLanzamiento = $row['FechaLanzamiento'];
                                $titulo = $row['Titulo'];
                            }
                            $stmt->close();
                            $sql = "SELECT Nombre 
                            FROM Artistas 
                            JOIN Discos ON Artistas.ArtistaID = Discos.ArtistaID 
                           WHERE Discos.DiscoID = ?";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("i", $discoID);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($row = $result->fetch_assoc()) {
                      $NOMBRE= $row['Nombre'];
                  }
                  $stmt->close();
      
            
                    
                            // Imprimir la información del disco
                            echo '<div class="album-info">';
                            echo '<img src="portadas/' . htmlspecialchars($portada) . '" alt="Nombre del Álbum">';
                            echo '<div class="album-details">';
                            echo '<p>Álbum</p>';
                            echo '<h1 style="font-size: 50px;">' . htmlspecialchars($titulo) . '</h1>';
                            echo '<p><strong>' . htmlspecialchars($NOMBRE) . '</strong> • ' . substr($fechaLanzamiento, 0, -6) . ' • ' . count($cancionesNombre) . ' canciones,'.$duracionTotal.'</p>';
                            echo '</div>';
                            echo '</div>';
                    
                            echo '<div class="playlist">';
                            echo '<div id="play">';
                            echo '<i class="bi bi-play-circle-fill" id="logoplay"></i>';
                            echo '</div>';
                            echo '<div class="playlist-header">';
                            echo '<div class="play-button"><strong>#</strong></div>';
                            echo '<div class="title"><strong>Título</strong></div>';
                            echo '<div class="artist"><strong>Artista</strong></div>';
                            echo '<div class="album"><strong>Álbum</strong></div>';
                            echo '<div class="duration"><strong><i class="bi bi-clock-fill"></i></strong></div>';
                            echo '</div>';
                    
                            // Contenedor para las canciones
                            echo '<div class="songs">';
                            foreach ($cancionesNombre as $index => $cancion) {
                                echo '<div class="song" data-index="' . $index . '">';
                                echo '<div class="play-button">' . htmlspecialchars($index + 1) . '</div>';
                                echo '<div class="title">' . htmlspecialchars($cancion) . '</div>';
                                echo '<div class="artist">' . htmlspecialchars($NOMBRE) . '</div>';
                                echo '<div class="album">' . htmlspecialchars($titulo) . '</div>';
                                echo '<div class="duration">' . htmlspecialchars($duracion[$index]) . '</div>';
                                echo '</div>';
                            }
                            echo '</div><br><br>'; // Cierre del contenedor de canciones
                            echo '</div>'; // Cierre del playlist
                        } finally {
                            // Cerrar la conexión después de cada iteración si es necesario
                        }
                    }
                

                   
                        // Consulta para extraer rutas de los archivos de audio para cada disco
                        $sql = "SELECT nombre_audio, nombre_archivo 
                                  FROM archivos_musica
                                  JOIN discos ON discos.DiscoID = archivos_musica.DiscoID
                                  WHERE ArtistaID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $IdRecibido);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $archivosPorDisco = [];
                        $rutasPorDisco = [];

                        while ($row = $result->fetch_assoc()) {
                            $archivosPorDisco[] = $row['nombre_audio'];
                            $rutasPorDisco[] = $row['nombre_archivo'];
                        }


                        //print_r($archivosPorDisco);

                        $stmt->close();
                    

                            $conn->close();
                            
                    
                            ?>
                    
                        
                            
                    </div>
                     </div>



        
		</section>
		
	</div> 	


                    <footer>
                            
                            
                            <audio ></audio>
                            <p id="cancionplay">artista-canción</p>
                    <div class="contenedorIconos">
                        <div class="conteinerButtonTime">
                                    <div >
                                    <p id="current_time">00:00:00</p>
                                    </div>	
                                <div class="buttons">
                                    <div id="prev" style="font-size: 1.6rem;">
                                    <i class="bi bi-rewind-circle"></i>
                                    </div>
                                    <div id="play1">
                                    <i class="bi bi-play-circle"></i>
                                    </div>
                                    <div id="next" style="font-size: 1.6rem;">
                                    <i class="bi bi-fast-forward-circle"></i>
                                    </div>	
                                </div>
                                    <div>
                                        <p id="current_audio"></p>
                                    </div>
                        </div>	
                        <div class="progresConteiner">
                            <div id="progress"></div> 
                    </div>	
                        
                    </div> 
                        
                            
                    </footer>



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
            //SECCION PARA MANEJAR REPRODCUTOR
		var audio= document.querySelector('audio');
		var cancion= document.getElementById('cancionplay');
		var prev= document.getElementById('prev');
		var play= document.getElementById('play');
		var next=document.getElementById('next');
		var current_time=document.getElementById('current_time');
		var current_audio=document.getElementById('current_audio');
		var progres=document.getElementById('progres');
		var progresConteiner=document.querySelector('.progresConteiner');
        var canciones = <?php echo json_encode($archivosPorDisco); ?>;
        var ruta=<?php echo json_encode($rutasPorDisco); ?>;
		var audioIndex=0;//con esto podria hacer que el usuario eligiera que cancion comienza
        
        loadAudio(audioIndex) 
        function loadAudio(index) {
            cancion.textContent = canciones[index];  // Asigna el nombre de la canción actual al texto descriptivo.
            audio.src = `discos/${ruta[index]}`;  // Asigna la ruta del archivo de la canción actual al reproductor.
            audioIndex = index;  // Actualiza el índice global de audio
            audio.load(); // Carga la nueva fuente de audio.

            // Elimina el event listener anterior para evitar múltiples triggers
            audio.removeEventListener("ended", handleSongEnd);

            // Añade el event listener para cargar la siguiente canción cuando la actual termine
            audio.addEventListener("ended", handleSongEnd);

            audio.addEventListener("loadedmetadata", () => {
                timesong(audio.duration, current_audio); // Actualiza el tiempo de la canción.
            });
        }

        function handleSongEnd() {
            nextSong(); // Llama a nextSong para cargar la siguiente canción
            playSong(); // Opcional, para reproducir automáticamente la siguiente canción
        }

        //AQUI ESTOY MANEJANDO QUE CADA CANCION ESTE ASOCIADA 

        document.addEventListener('DOMContentLoaded', function() {
            // Obtén todos los elementos de canción
            var songs = document.querySelectorAll('.song');

                    // Asigna un evento click a cada canción
                    songs.forEach((song, index) => {
                        song.addEventListener('click', () => {
                            loadAudio(index);  // Carga y reproduce la canción correspondiente
                            playSong();
                        });
                    });
                });


                function playSong() {
                var icono = document.querySelector('#play i');
                var icono1 = document.querySelector('#play1 i'); // Asume que hay un i dentro de #play1

                audio.play();
                
                // Ajusta el ícono para reflejar el estado de "reproduciendo"
                icono.classList.remove('bi-play-circle-fill');
                icono.classList.add('bi-pause-circle-fill');
                
                icono1.classList.remove('bi-play-circle');
                icono1.classList.add('bi-pause-circle');
                
                // Agrega la clase 'play' para indicar que está reproduciendo
                document.querySelector('#play').classList.add('play');
                document.querySelector('#play1').classList.add('play');
            }

            function pauseSong() {
                var icono = document.querySelector('#play i');
                var icono1 = document.querySelector('#play1 i');
                
                audio.pause();
                
                // Ajusta el ícono para reflejar el estado de "pausado"
                icono.classList.remove('bi-pause-circle-fill');
                icono.classList.add('bi-play-circle-fill');
                
                icono1.classList.remove('bi-pause-circle');
                icono1.classList.add('bi-play-circle');
                
                // Elimina la clase 'play' para indicar que está pausado
                document.querySelector('#play').classList.remove('play');
                document.querySelector('#play1').classList.remove('play');
            }
       


		function updateBarProgress(e){
			var{ duration, currentTime}=e.srcElement
			var progressPercent=(currentTime/duration)* 100;

			progress.style.width = progressPercent + "%";

		}
        //esta funcion me coloca en el punto que quiero de la barra 
		//de tiempo
        function setProgress(e){
			var width = this.clientWidth;
			var clickPosition = e.offsetX;
			var duration= audio.duration;
			audio.currentTime =(clickPosition/width)*duration;

 
		} 
		//este evento permite dara al play con la barra de espacio
		document.addEventListener('keydown', function(e) {
   		 if (e.code === 'Space') {
        e.preventDefault(); // Prevenir el comportamiento por defecto de la barra de espacio (scroll)
        var isPlaying = play.classList.contains('play');
        if (!isPlaying) {
            playSong();
        } else {
            pauseSong();
        }
			}
		});

		function prevSong(){
			audioIndex--
			if(audioIndex < 0){
				audioIndex =canciones.length -1;
			}
			loadAudio( audioIndex);
			playSong();

		}
		function nextSong(){
			audioIndex ++
			if(audioIndex>canciones.length -1){
				audioIndex =0;	

			}
			loadAudio( audioIndex);
			playSong();
		}

		document.querySelector('#play').addEventListener('click', togglePlayPause);
        document.querySelector('#play1').addEventListener('click', togglePlayPause);

        function togglePlayPause() {
            var isPlaying = document.querySelector('#play').classList.contains('play');
            if (!isPlaying) {
                playSong();
            } else {
                pauseSong();
            }
        }
                

		function timesong(audio, element){
			var totalSecond =Math.round(audio);
			var minutes = Math.floor(totalSecond/60);
			var seconds =totalSecond % 60;
			
			element.textContent ="00:"+ minutes.toString().padStart(2,"0") + ":" + seconds.toString().padStart(2,"0");

		}

		audio.addEventListener("timeupdate", (e)=>{
			updateBarProgress	(e)
			timesong(audio.currentTime, current_time );
		});
		progresConteiner.addEventListener("click",setProgress) ; 
		prev.addEventListener("click",prevSong) ; 
		next.addEventListener("click",nextSong) ; 










  

	</script>

		

</body> 

</html>
