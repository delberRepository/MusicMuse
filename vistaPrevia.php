<?php
      
	   session_start(); // Asegúrate de que la sesión esté iniciada
	   
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


        if (isset($_POST["submit"])) {
            $directorioDestino = "portadas/"; 
        
            $nombreDisco = preg_replace('/[^A-Za-z0-9 ]/', '', $_POST['albumName']); // Limpia el nombre de la canción
            $nombreArtista = preg_replace('/[^A-Za-z0-9 ]/', '', $_SESSION['Artista']); // Limpia el nombre del artista
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
        
            $archivoFinal = $nombreArtista . "-" . $nombreDisco . "." . $tipoArchivoOriginal; // Forma el nombre del archivo final, incluyendo la extensión
            $rutaArchivoFinal = $directorioDestino . $archivoFinal; // Construye la ruta completa del archivo final
            //almaceno cartula en variable
            $_SESSION['caratula'] = $archivoFinal;
        
            // Intenta subir el archivo
            if (move_uploaded_file($_FILES["albumArt"]["tmp_name"], $rutaArchivoFinal)) {
               // echo "El disco ha sido caragado correctamente.";
            
            } else {
                echo "Hubo un error.";
            }
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

        .container {
            width: 100%;
            margin: 0 auto;
            background-color: #1D1C1C;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius:4px;
            
        }

        .upload-section {
            display: flex;
            flex-direction: column;
            margin-left:70px;
        }

        .form-group {
            margin-bottom: 10px;
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
            background-color:  #1D1C1C; /* Elige el color de fondo adecuado */
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            /*align-items: center;*/
            height: 360px;
            margin: 0px -12px;
        }
        .album-info {
            display: flex;
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
            background-color: #121212;
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
       
     
       

        /* Ajusta los colores, márgenes y otros estilos según tus necesidades */

   </style>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    
    <link href="estiloPag.css" rel="stylesheet" type="text/css"> 
</head>  
<body>



 <div class="totalNav">

	
	<nav>
    <ul >
        <?php if (isset($_SESSION['usuario'])): ?>
            <li class="nav-item">
                <?= "Hola ".htmlspecialchars($_SESSION['usuario']) ."!"; ?>
                <ul class="dropdown-content">
				<li ><a href="FormularioAddMusica.php">Subir Música</a></li>
				<li>Editar perfil</li>	
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
			  <div class="iconos">	
			  <i class="bi bi-cassette-fill"></i>
			  </div>	
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
		<section id="altura"> 
		 
         <!-- AQUI ES DODNDE ESTA LA INFORMACION GENERAL DEL ARTISTA-->
              <?php 
              if (isset($_SESSION['canciones']) && !empty($_SESSION['canciones'])) {
              $canciones=0;
              foreach ($_SESSION['canciones'] as $cancion) {
                $canciones++;
              }
            }
              ?>

             <div class="container">
                 <div class="header">
                    <div class="atras">
                       <a href="FormularioAñadirMusica.php"> 
                         <i class="bi bi-rewind-circle-fill"></i>
                       </a>  
                        <i class="bi bi-fast-forward-circle-fill"></i>
                    </div>  
                    <div class="album-info">
                    <img src="portadas/<?php echo $_SESSION['caratula'];?>" alt="Nombre del Álbum">
                    <div class="album-details">
                        <p >Álbum</p>
                        <h1 style="font-size: 70px;"><?php echo $_SESSION['albumName'];?></h1>           <!--aqui tengo que sumar todos los minutos y segundos de las canciones y ponerlos-->
                        <p><strong><?php echo $_SESSION['Artista'];?></strong> • <?php echo substr($_SESSION['releaseDate'],  0, -6);?> • <?php echo $canciones ?> canciones, 36 min 21 s</p>
                    </div>
                    </div>
                </div>    



            <div class="playlist">
                <div class="playplay">
                    <i class="bi bi-play-circle-fill" id="logoplay"></i>
                </div>    
                <div class="playlist-header">
                    <div class="play-button"><strong>#</strong></div>
                    <div class="title"><strong>Título</strong></div>
                    <div  class="artist"><strong>Artista</strong></div>
                    <div class="album"><strong>Álbum</strong></div>
                    <div class="duration"><strong>   <i class="bi bi-clock-fill"></i></strong></div>
                
                
                </div>


                <!-- Contenedor para las canciones -->
                    <div class="songs">
                        <?php
                        if (isset($_SESSION['canciones']) && !empty($_SESSION['canciones'])) {
                            $id = 1;

                            foreach ($_SESSION['canciones'] as $cancion) {
                                // Asegúrate de que 'song' sea una clase aplicada a un contenedor que agrupe todos los datos de una canción.
                                echo '<div class="song">';
                                echo '<div class="play-button">' . htmlspecialchars($id) . '</div>';
                                echo '<div class="title">' . htmlspecialchars($cancion['nombre']) . '</div>';
                                echo '<div class="artist">' . htmlspecialchars($_SESSION['Artista']). '</div>';
                                echo '<div class="album">' .  $_SESSION['albumName']. '</div>'; // Aquí parece que debería ir el nombre del álbum
                                echo '<div class="duration">'. htmlspecialchars($cancion['duracion']) .'</div>'; // Suponiendo que '4:21' es solo un marcador de posición
                               
                                echo '</div>'; // Cierre del contenedor de la canción
                                $id++;
                            }
                        }
                        ?>
                    </div>

                <!-- Repite este bloque para cada canción en tu lista 
                <div class="song">
                    <div class="play-button" id="numero">1</div>
                    <div class="title" id="titulo">All News Is Good News</div>
                    <div class="artist" id="artist">Surprise Chef</div>
                    <div class="album" id="disco">All News Is Good News</div>
                    <div class="duration" id="duracion">4:21</div>
                </div>
                <div class="song">
                    <div class="play-button">2</div>
                    <div class="title">The black Dog in Sicilia</div>
                    <div class="artist">Surprise Chef</div>
                    <div class="album">All News Is Good News</div>
                    <div class="duration">4:21</div>
                </div>
                <div class="song">
                    <div class="play-button">3</div>
                    <div class="title">Goku is My Sayahin</div>
                    <div class="artist">Surprise Chef</div>
                    <div class="album">All News Is Good News</div>
                    <div class="duration">4:21</div>
                </div>
                <div class="song">
                    <div class="play-button">4</div>
                    <div class="title">Cat, doggi, pixie</div>
                    <div class="artist">Surprise Chef</div>
                    <div class="album">All News Is Good News</div>
                    <div class="duration">4:21</div>
                </div>
                           -->
            </div>
                </div>



        
		</section>
		
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
		var canciones=['Cubeta Muerta', 'La Ultranada'];
		var audioIndex=0;
        loadAudio(canciones[audioIndex]) 

		function loadAudio(cancionPasada){
			cancion.textContent=cancionPasada
			audio.src=`discos/${cancionPasada}.wav`

			audio.addEventListener("loadedmetadata", ()=>{
				timesong(audio.duration, current_audio)
			})

			 
		}
        function playSong(){
			play.classList.add('play')
			var icono=play.querySelector('i.bi')
			icono.classList.remove('bi-play-circle')
			icono.classList.add('bi-pause-circle') 

			audio.play()
			

		}
		function pauseSong(){
			play.classList.remove('play')
			var icono=play.querySelector('i.bi')
			icono.classList.add('bi-play-circle')
			icono.classList.remove('bi-pause-circle')

			audio.pause()
			

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
			loadAudio( canciones[audioIndex]);
			playSong();

		}
		function nextSong(){
			audioIndex ++
			if(audioIndex>canciones.length -1){
				audioIndex =0;	

			}
			loadAudio( canciones[audioIndex]);
			playSong();
		}

		play.addEventListener("click",() =>{
		 
		 var isplaying= play.classList.contains('play')
		  if(!isplaying){
			playSong()
		  }else{
			pauseSong()
		  }
		});

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
