
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
	   $nombreUsu = $_SESSION['usuario'];  

	   $host = 'localhost';
	   $usuario = 'root';
	   $nombre_base_datos = 'BaseMusicas';
	   
	   // Crear una única conexión
	   $conn = new mysqli($host, $usuario, "", $nombre_base_datos);
	   
	   if ($conn->connect_error) {
		   die("Conexión fallida: " . $conn->connect_error);
	   }
	   
	   mysqli_set_charset($conn, "utf8");
	   
	  
	   $sql = "SELECT Rol 
	             FROM Usuarios 
				WHERE NombreUsuario = ?";
	   $stmt = $conn->prepare($sql);
	   $stmt->bind_param("s", $nombreUsu);
	   $stmt->execute();
	   $result = $stmt->get_result();

	   if ($result->num_rows > 0) {
		// Obtener el rol del usuario
		$row = $result->fetch_assoc();
		if ($row['Rol'] == "artista") {
			$_SESSION['rol'] = 0;
		} else {
			$_SESSION['rol']  = 1;
		}
	} 
	   
	   $stmt->close();
	   
	   ?>
	   
<!DOCTYPE html>
<html lang="es">  
<head>    
    <title>IndieSound</title>    
    <meta charset="UTF-8">
    <meta name="title" content="MusicMuse">
    <meta name="description" content="La App para artistas emergentes">  
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    
   <link href="estiloPag.css" rel="stylesheet" type="text/css"> 
    
   <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Turret+Road:wght@200;300;400;500;700;800&display=swap" rel="stylesheet">
	<style>
        /* Estilos para el botón */
			button {
				padding: 10px 20px;
				font-size: 16px;
				cursor: pointer;
			}

			/* El popup (por defecto está oculto) */
			.popup {
				display: none; /* Oculto por defecto */
				position: fixed; /* Posición fija */
				z-index: 1; /* Sobre otros elementos */
				left: 0;
				top: 0;
				width: 100%; /* Ancho completo */
				height: 100%; /* Alto completo */
				background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
			
			}

			/* Contenido del popup */
			.popup-content {
				background-color: #fff;
				margin: 15% auto; /* 15% desde la parte superior y centrado horizontalmente */
				padding: 20px;
				border: 1px solid #888;
				width: 80%; /* Ancho del 80% */
				max-width: 500px; /* Ancho máximo */
				border-radius: 5px; /* Bordes redondeados */
				margin-top: 20px;
			}

			/* Botón de cierre (x) */
			.closeBtn {
				color: #aaa;
				float: right;
				font-size: 28px;
				font-weight: bold;
				cursor: pointer;
			}

			.closeBtn:hover,
			.closeBtn:focus {
				color: #000;
				text-decoration: none;
				cursor: pointer;
			}

    </style>
</head>  
<body> 

 <div class="totalNav">

 
	
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
		
		
		<!-- VENTANA  CREAR CUENTA -->
	<div id="ventana1" class="ventana">
		<!-- Contenido del modal -->
		<div class="contenidoVentana">
		<div class="rotulo"> 
			<!-- &times; representa una x -->
			<span class="close">&times;</span>
			<p>Registrarse para una cuenta de MusicMuse</p>
		</div>       
			<!-- Contenido adicional  aquí -->
		<div class="botones"> 
			<img class="fotosReg" src="bit.png"  alt="...">  
			<a href="FormArtista.php">  
			<input type="button" id="artista" value="Registrarse como artista"  class="boton">  
			</a>  
		</div>      
			<hr>
		<div class="botones">      
			<img  class="fotosReg" src="fanes.png"  alt="...">  
			<a href="formularioFan.php">     
			<input type="button" id="fan" value="Registrarse como fan" class="boton">
			</a>       
			
		</div>        
		</div>
	</div>
	
</div>

   


    <div class="contenedorAB">	 
					<aside>
							<div class="caja1"> 
							<div class="tuMusica" >	
								<div class="iconos">	
								<i class="bi bi-houses-fill"></i>
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
									<div id="inputContainer" style="margin-left:10px"></div>

							<article>



								<!-- El popup -->
								<div id="myPopup" class="popup">
									<div class="popup-content">
										<span class="closeBtn">&times;</span>
										<img class="barry"  src="BARRY-WHITE.jpeg">
										<p style="text-align: center; color:#888">REGISTRATE PARA PODER ACCEDER A TODOS NUESTROS ARTISTAS Y FUNCIONES PREMIUM.</p>
									</div>
								</div>


							<h2 style="text-align: center;">ARTISTAS DE LA SEMANA</h2>
							<div class="container">
								<div class="row artSemana">
								<div class="col-lg-3 col-md-6 mb-4">
									<div class="card  fixed-height-card" style="width: 16rem ;background-color: #2D2C2C">
									<div style="position: relative;">
										<img src="administrador/fotos/vindaloo.png" class="card-img-top" alt="...">
										<div class="logo-overlay">
										<img class="logo" src="play.svg" alt="Logo" data-audio="administrador/canciones/Toni Manzino - Perro Azul.wav">
										</div>
									</div>
									<a href="Toni.php">
										<div class="card-body">
										<h3>Toni Manzino</h3>
										<p class="card-text">Toni Manzino nos presenta su ultimo single "Perro azul", con su personal estilo lugubre y tenebroso al que nos tiene acostumbrado.</p>
										</div>
									</a>
									</div>
								</div>
								<div class="col-lg-3 col-md-6 mb-4">
									<div class="card fixed-height-card" style="width: 16rem; background-color: #2D2C2C" >
									<div style="position: relative;">
										<img src="administrador/fotos/caratulaMuqui.jpg" class="card-img-top" alt="...">
										<div class="logo-overlay">
										<img class="logo" src="play.svg" alt="Logo" data-audio="administrador/canciones/Muqui - Tarde de Abril.wav">
										</div>
									</div>
									<a href="Muqui.php">
										<div class="card-body">
										<h3>Muqui</h3>
										<p class="card-text">Exquisito corte del proyecto en solitario de Boris McFardam ex-Delber Grady, que nos ha sorprendido con su dulzura.</p>
										</div>
									</a>
									</div>
								</div>
								<div class="col-lg-3 col-md-6 mb-4">
									<div class="card fixed-height-card" style="width: 16rem; background-color: #2D2C2C">
									<div style="position: relative;">
										<img src="administrador/fotos/cebollita.jpg" class="card-img-top" alt="...">
										<div class="logo-overlay">
										<img class="logo" src="play.svg" alt="Logo" data-audio="administrador/canciones/Cebollita Macabra - Introducción al Mundo de Mike.wav">
										</div>
									</div>
									<a href="cebollitaMacabra.php">
										<div class="card-body">
										<h3 style="font-size: 25px;">Cebollita Macabra</h3>
										<p class="card-text">Aquí rescatamos este mítico LP de la malograda banda "Cebollita Macabra", los superhéroes del Funk-Progresivo de los 2000.</p>
										</div>
									</a>
									</div>
								</div>
								<div class="col-lg-3 col-md-6 mb-4">
									<div class="card fixed-height-card" style="width: 16rem; background-color: #2D2C2C">
									<div style="position: relative;">
										<img src="administrador/fotos/delber.jpg" class="card-img-top" alt="...">
										<div class="logo-overlay">
										<img class="logo" src="play.svg" alt="Logo" data-audio="administrador/canciones/Delber Grady - Stay.wav">
										</div>
									</div>
									<a href="Delber.php">
										<div class="card-body">
										<h3>Delber Grady</h3>
										<p class="card-text">Segundo Ep de la banda "Delber Grady", fundada por miembros de Cebollita Macabra. Considerada la banda de Dracula</p>
										</div>
									</a>
									</div>
								</div>
								</div>
							</div>
							</article>
								
									
									<?php
								
											$sql = "SELECT 
											a.ArtistaID, 
											a.UsuarioID, 
											a.nombre, 
											a.descripcion, 
												(SELECT ImagenPortada 
												FROM discos d 
												WHERE d.ArtistaID = a.ArtistaID 
												LIMIT 1) as ImagenPortada 
													FROM 
														artistas a
													INNER JOIN 
														discos d ON a.ArtistaID = d.ArtistaID
													GROUP BY 
														a.ArtistaID";

										$result = $conn->query($sql);


										if (isset($_SESSION['usuario'])): ?>
									
								<article>
										<h2 style="text-align: center;">TODOS NUESTROS ARTISTAS</h2> 
										<div class="row artSemana"> 
										

										<?php

										
											if ($result->num_rows > 0) {
												while($row = $result->fetch_assoc()) {
													// Limitar la descripción a 8 palabras
													$descripcion = $row['descripcion'];
													$palabras = explode(' ', $descripcion);
													if (count($palabras) > 8) {
														$descripcion = implode(' ', array_slice($palabras, 0, 6)) . '...';
													}

													
											
													echo '<div class="card" style="width: 16rem; background-color: #2D2C2C">';
													echo '<div style="position: relative;">';
													echo '<img src="portadas/'.$row['ImagenPortada'].'" class="card-img-top" alt="..." style="height: 230px;">';
													echo '</div>';
													// Enlace con el ID del artista como parámetro en la URL
													echo '<a href="perfil.php?artista_id='.$row['ArtistaID'].'">';
													echo '<div class="card-body">';
													echo '<h3 style="font-size:20px">'.$row['nombre'].'</h3>';
													echo '<p class="card-text">' . $descripcion . '</p>';
													echo '</div>';
													echo '</a>';
													echo '</div>';
												}
											} else {
												echo "No hay artistas disponibles.";
											}
											
											$conn->close();
											
											?>  

								</article>
									<?php endif; ?>
										<!-- <article>
											<h2>Listas destacadas de la semana</h2>

										</article>	-->
										</div>
									</div> 	  
					</section>
						
						
						<footer>
							
							
							<audio></audio>
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
									<div id="play" >
									<i class="bi bi-play-circle" id="openPopupBtn"></i>
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
	</div>   
	<script type="text/javascript">

	
	
				var searchButton = document.getElementById('searchButton');
				var inputContainer = document.getElementById('inputContainer');

				// Función para añadir el input de texto dentro de un formulario
				function Buscar() {
				// Crear el elemento formulario
				var form = document.createElement('form');
				form.action = 'filtrados.php';  // Enviar a la página de filtrado
				form.method = 'get';            // Método GET

				// Crear el elemento input
				var input = document.createElement('input');
				input.type = 'text';
				input.name = 'filtrado';          // Importante para que el valor se envíe correctamente
				input.placeholder = '¿Qué te apetece escuchar?';
				input.className = 'inputBusqueda';

				// Crear un botón de envío para el formulario
				var submitButton = document.createElement('input');
				submitButton.type = 'submit';
				submitButton.value = 'Buscar';
				submitButton.style.display = 'none'; 

				// Añadir el input y el botón al formulario
				form.appendChild(input);
				form.appendChild(submitButton);

				// Limpiar el contenedor primero y añadir el formulario
				inputContainer.innerHTML = '';
				inputContainer.appendChild(form);
				}

				// Agregar evento click al botón de búsqueda
				searchButton.addEventListener('click', Buscar);


		
       
				
				document.addEventListener('DOMContentLoaded', function () {
    // Para el primer modal
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
			/*	var btn2 = document.getElementById('openVentana2');
				var ventana2 = document.getElementById('ventana2');
				var span2 = document.querySelector('.close2'); // Asegúrate de que esta clase exista en tu botón de cerrar del segundo modal

				if (btn2 && ventana2 && span2) {
					btn2.onclick = function() {
						ventana2.style.display = 'block';
					}

					span2.onclick = function() {
						ventana2.style.display = 'none';
					}
				}*/
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
		var canciones=['Cebollita Macabra - Introducción al Mundo de Mike', 
		'Delber Grady - Stay', 'Toni Manzino - Perro Azul', 'Muqui - Tarde de Abril'];
		var audioIndex=1;

        loadAudio(canciones[0]) 
		 

		function loadAudio(cancionPasada){
			cancion.textContent=cancionPasada
			audio.src=`administrador/canciones/${cancionPasada}.wav`
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

		document.querySelectorAll('.logo').forEach(item => {
        item.addEventListener('click', function() {
            var audioFile = this.getAttribute('data-audio');
            if (audioFile) {
                audio.src = audioFile;
				var icono=play.querySelector('i.bi')
				icono.classList.remove('bi-play-circle')
				icono.classList.add('bi-pause-circle') 
				//esta parte del codigo maneja que pueda usar el espacio para dar a play y pausa
				var isPlaying = play.classList.contains('play');
				if (!isPlaying) {
					playSong();
				} else {
					pauseSong();
				}
			
				

                audio.play();
				cancion.textContent = audioFile.split('/').pop().split('.').slice(0, -1).join('.');
                updateBarProgress({ srcElement: audio });
				
            }
        });
    });

       


		

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
		/*document.addEventListener('keydown', function(e) {
   		 if (e.code === 'Space') {
        e.preventDefault(); // Prevenir el comportamiento por defecto de la barra de espacio (scroll)
        var isPlaying = play.classList.contains('play');
        if (!isPlaying) {
            playSong();
        } else {
            pauseSong();
        }
			}
		});*/

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



		//POPUP para sugerir que se registren

		// Función que muestra el popup
        function showPopup() {
            var popup = document.getElementById("myPopup");
            popup.style.display = "block";
            // Almacenar en sessionStorage que el popup ha sido mostrado
            sessionStorage.setItem('popupShown', 'true');
        }

        // Obtener el <span> que cierra el modal
        var span = document.getElementsByClassName("closeBtn")[0];

        // Cuando el usuario hace clic en <span> (x), cierra el modal
        span.onclick = function() {
            var popup = document.getElementById("myPopup");
            popup.style.display = "none";
        }

        // Cuando el usuario hace clic fuera del modal, lo cierra
        window.onclick = function(event) {
            var popup = document.getElementById("myPopup");
            if (event.target == popup) {
                popup.style.display = "none";
            }
        }

        // Mostrar el popup la primera vez que se pulsa el botón
        document.getElementById('openPopupBtn').onclick = function() {
            if (!sessionStorage.getItem('popupShown')) {
                showPopup();
            }
        }



	</script>

		

</body>  
</html>
