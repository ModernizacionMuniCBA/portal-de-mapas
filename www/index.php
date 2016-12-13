<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

	session_start();



include './php/configuracion.php';


	if(isset($_SESSION['usuario'])){
		$usuario = $_SESSION['usuario'];

	}
	if(isset($_SESSION['id_usuario'])){
		$id_usuario=$_SESSION['id_usuario'];
	}

	if(isset($_SESSION['tipo_usuario'])){
		$tipo_user=$_SESSION['tipo_usuario'];
	}


?>




<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Emap - Catastro Municipal</title>
<!-- jQuery UI
	<link rel="stylesheet" href="./js/jquery/jquery-ui.min.css" />-->

	<?php



//include  './php/db/Conexion.php';

// create a PostgreSQL database connection
//$model = new Conexion;
//$conexion = $model->conectar();
//if(!$conexion){
//	echo "No se pudo conectar con la BD <strong>gisdb</strong>";
//}
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];

/*$referrer = $_SERVER['HTTP_REFERER'];
 if ($referred == "") {
  $referrer = "This page was accessed directly";
  }
*/

/*  $fecha = $timestamp = new DateTime();
  $strdfecha = $timestamp->format('Y-m-d H:i:s');
  $query = 'INSERT INTO public.visitors ('.'"Fecha",hora,'.'"IPAddress",'.'browser)';
  $query .='VALUES ('."'".$strdfecha."','".$strdfecha."','".$ip."','".$browser."'".')';

  $result = $conexion->prepare($query);
  $result->execute();
		*/






			if ($__LayerLibrary=="Openlayers"){
				//<!-- OpenLayers -->
				echo '<link rel="stylesheet" href="./js/openlayers/ol.css" />';

			}
			else
			{
				//<!-- Leaflet -->
				echo '<link rel="stylesheet" href="./js/leaflet/leaflet.css" />';



			}
	?>
	<script src="./js/leaflet/leaflet.js"></script><!--Leaflet -->
	<!-- Leaflet Plugins -->
	<link rel="stylesheet" href="./js/Leaflet-MiniMap-master/src/Control.MiniMap.css" />
	<link rel="stylesheet" href="./js/Leaflet.MousePosition-master/src/L.Control.MousePosition.css" />
	<link rel="stylesheet" href="./js/leaflet.fullscreen/Control.FullScreen.css">
	<link rel="stylesheet" href="./js/Leaflet-draw/leaflet.draw.css" />
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="./js/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome-->
	<link rel="stylesheet" type="text/css" href="./font-awesome/css/font-awesome.min.css">
	<!--estilos del mapa-->
	<link rel="stylesheet" type="text/css" href="./css/estilo.css">
	<!-- estilo del control de capas -->
	<link rel="stylesheet" type="text/css" href="./js/Leaflet-StyledLayerControl/css/styledLayerControl.css">
	<!-- <link rel="stylesheet" type="text/css" href="./js/Leaflet-GroupStyledLayer/leaflet.groupedlayercontrol.css"> -->

	<!--Bubble control-->
	<link rel="stylesheet" type="text/css" href="./js/L.Control.Basemaps/L.Control.Basemaps.css">


	<link rel="stylesheet" type="text/css" href="./css/simple-sidebar.css">
	<script src="./js/variablesGlobales.js"></script><!-- Variables Globales -->

	<!-- estilos del menu y menu lateral	 -->
	<link rel="stylesheet" type="text/css" href="./css/header.css">
	<link rel="stylesheet" type="text/css" href="./css/style-navbar.css">

	<script>
	<?php

			  /*tomamos el modo enviada por la URL*/
			/*  if (isset($_GET['modo']))
			  {
			   		$modo = $_GET["modo"];
					$_SESSION['modo']=$modo ;
			   /*obtengo modo para mostrar las capas*/
				//echo $modo;

			 /* }

			  /*tomamos la nomenclatura enviada por la URL*/
			  if (isset($_GET['nomenclatura']))
			  {
			   		$paramNomenclatura = $_GET["nomenclatura"];
					$_SESSION['paramNomenclatura']=$paramNomenclatura ;
			   /*obtengo la nomenclatura para centrar el mapa*/
				echo $paramNomenclatura;

			  }


			  /*tomamos la coordenadaX enviada por la URL*/
			  /*
			  if (isset($_GET['coordenadaX']))
			  {
			   		$paramCoordenadaX = $_GET["coordenadaX"];
					$_SESSION['coordenadaX']=$paramCoordenadaX ;
				echo $paramCoordenadaX;

			  }

			  /*tomamos la coordenadaY enviada por la URL*/
			  /*
			  if (isset($_GET['coordenadaY']))
			  {
			   		$paramCoordenadaY = $_GET["coordenadaY"];
					$_SESSION['coordenadaY']=$paramCoordenadaY ;

				echo $paramCoordenadaY;

			  }
*/




	?>

//			modo = '<?php if(isset($modo)) echo $modo; else echo "google" ?>';
			paramNomenclatura = '<?php if(isset($paramNomenclatura)) echo $paramNomenclatura; ?>';
			//paramcoordenadaY= '<?php if(isset($paramCoordenadaY)) echo $paramCoordenadaY; ?>';
			//paramcoordenadaX= '<?php if(isset($paramCoordenadaX)) echo $paramCoordenadaX; ?>';

	</script>


</head>
<body id ="cuerpo">

	<!-- MENU SECTION -->
	<div id="menu-wrapper" class="active">
			<ul class="sidebar-nav" id="filter-navbar">

			</ul>
	</div>

	<nav class="navbar navbar-fixed-top navbar-emap" role="navigation" id="encabezado">

		<div class="navbar-header" style="display: inline-block;">
			<button type="button" id="menu-button" class="active">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">Menú
			<!-- <span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span> -->
			</button>

			<!-- <a id="menu-button" class="btn btn-info" href="#">MENU</a> -->
		</div>
		<div class="navbar-header navbar-header-right pull-right">
			<a class="navbar-logo" href="./">
				<img src="./images_emap/logo-municipalidad.png" class="img-responsive header-logo">
			</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#" id="modoConsulta" onClick="">Modo Consulta</a></li>
					<li class="active hidden"><a href="#" id="modoDibujo" onClick="">Modo Dibujo</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Acciones <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#" type="button" class="disabled" data-toggle="tooltip"  id="vistaCompleta" onclick="centrarMapa()" data-placement="bottom"><span class="glyphicon glyphicon-globe" ></span> Centrar Mapa</a></li>
							<li><a href="#" type="button" class="disabled" id="imprimir" data-toggle="tooltip" data-placement="bottom" onclick="habilitarImpresion();"><span class="glyphicon glyphicon-print"></span> Habilitar Impresion</a></li>
							<li><a href="#"type="button" class="disabled" id="ir" data-placement="bottom" data-toggle="modal" data-target="#modalIrAlPunto"><span class="glyphicon glyphicon-record"></span> Ir al punto</a></li>
							<li><a href="#" type="button" class="disabled" data-toggle="tooltip"  id="mostrarCoordenadas" data-placement="bottom" onclick="abrirMarcadorCoordenadas()"><span class="glyphicon glyphicon-map-marker"></span> Mostrar marcador</a></li>
							<li><a href="#" type="button" class="disabled" data-toggle="tooltip"  id="busquedaAvanzada" data-placement="bottom"  onclick="busquedaAvanzada()">
							<span class="glyphicon glyphicon-search"></span> Búsqueda avanzada
							</a></li>
							<li><a href="#" type="button" class="disabled" id="limpiarBusqueda"  onclick="limpiarBusqueda()" data-toggle="tooltip" data-placement="bottom">
								<span class="glyphicon glyphicon-trash"></span> Limpiar mapa
							</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#" type="button" class="" id="mostrarinformacion" onclick="mostrarinformacion()" data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-info-sign"></span> Mostrar Información</a></li>
							<li><a href="#" type="button" class="active" id="navegar" onclick="Navegar()" data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-hand-up"></span> Navegar</a></li>
							<li><a href="#" type="button" class="" id="mostrarparcelario" onclick="mostrarparcelario()" data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-share"></span> Mostrar Parcelario</a></li>
							<li><a href="#" type="button" class="btn  btn-default " id="habilitarReclamos"  onclick="habilitarReclamos()" data-toggle="tooltip"  data-placement="bottom"><span class="glyphicon glyphicon-wrench"></span> Registrar Reclamo</a></li>
							<li role="separator" class="divider"></li>
							<li><a id="btn-iniciarSesion" data-toggle="modal" data-target="#" href="#">Ingresar</a></li>
							<li class="dropdown hidden" id="ddlUsuario">
								<a id="lblUsuarioLogueado" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									<i class="fa fa-user"></i>
									<label id="txtUsuarioLogueado"></label>
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu" id='mmenu'>
									<li class="hidden" id="mensajesAdmin"><a target="_blank" id="linkAdmin" href="#"><i class="fa fa-envelope-o"></i> Nuevos: <span class="badge" id="nroMensajesNvos"></span> - Comentarios: <span class="badge" id="nroMensajesRevisados"></span></a></li>
									<li id="mensajesUsuario"><a target="_blank" id="linkUsuario" href="#"><i class="fa fa-envelope-o"></i> Ver mensajes <span class="badge" id="nroMensajes"></span></a></li>
									<?php
									if(isset($_SESSION['tipo_usuario']))
						 				if($_SESSION['tipo_usuario']==1)
											echo '<li id="adminuser"><a target="_blank" id="linkGestionUsuarios" href="./php/gestionUsuarios.php"><i class="fa fa-users"></i>  Gestionar usuarios</a></li>';
									?>
									<li><a href="#" data-toggle="modal" data-target="#modalCambiarContraseÃ±a"><i class="fa fa-lock"></i>  Cambiar contraseÃ±a</a></li>
									<li class="divider" id='divider'></li>
									<li><a href="#" onclick='cerrarSesion();'><i class="fa fa-power-off"></i>  Cerrar sesiÃ³n</a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
					<!--<form class="form-inline" role="search">-->
						<div class="form-group" >
							<div id="cuadroBusqueda" class="input-group input-menu" data-toggle="tooltip"  title="Desplazarse a dirección">
								<span class="input-group-addon search-icon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></span>
								<input type="search" id="txtBusqueda" class="form-control disabled" placeholder="Ingrese una dirección"  onkeypress="validarDireccion()" disabled/>
								<span class="input-group-btn">
									<button id="btnBuscarDireccion" class="btn btn-buscar disabled" type="button" onclick="codeAddress()"><span class="texto">Ir</span></button>
								</span>
							</div>
						</div>
					<!--</form>-->
			</div><!--/.nav-collapse -->
	</nav>
		<!-- MENU SECTION END -->


 	<nav class="navbar navbar-default " id="encabezado">
		<div  style="padding-left:0">



				<div class="navbar-header col-md-9" style="margin-top: 0px !important; margin-bottom: 0px !important; padding-top: 0px !important; padding-bottom: 0px !important;">
					<div class="row" >
						 <ul class="nav navbar-nav navbar-right col-md-1"style="padding-right:0">
							<li id="divBtnIniciarSesion">

 								<a id="btn-iniciarSesion" data-toggle="modal" data-target="#" href="#" style="color: #A8A9AD">Ingresar</a>
							</li>
							<li class="dropdown hidden" id="ddlUsuario">
								<a id="lblUsuarioLogueado" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									<i class="fa fa-user"></i>
									<label id="txtUsuarioLogueado"></label>
									<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu" id='mmenu'>
									<li class="hidden" id="mensajesAdmin"><a target="_blank" id="linkAdmin" href="#"><i class="fa fa-envelope-o"></i> Nuevos: <span class="badge" id="nroMensajesNvos"></span> - Comentarios: <span class="badge" id="nroMensajesRevisados"></span></a></li>
									<li id="mensajesUsuario"><a target="_blank" id="linkUsuario" href="#"><i class="fa fa-envelope-o"></i> Ver mensajes <span class="badge" id="nroMensajes"></span></a></li>
									<?php
									if(isset($_SESSION['tipo_usuario']))
						 				if($_SESSION['tipo_usuario']==1)
											echo '<li id="adminuser"><a target="_blank" id="linkGestionUsuarios" href="./php/gestionUsuarios.php"><i class="fa fa-users"></i>  Gestionar usuarios</a></li>';
									?>
									<li><a href="#" data-toggle="modal" data-target="#modalCambiarContraseÃ±a"><i class="fa fa-lock"></i>  Cambiar contraseÃ±a</a></li>
									<li class="divider" id='divider'></li>
									<li><a href="#" onclick='cerrarSesion();'><i class="fa fa-power-off"></i>  Cerrar sesiÃ³n</a></li>
								</ul>
							</li>
						</ul>

            		</div>
			</div>


			</nav>



<div id="headerImpresion" class="header hide"style="display:none">
	<strong style="font-size:20px;margin:0 auto;">PLANO DE REGISTRO GRAFICO PARCELARIO</strong>
</div>

<!-- <div class="container-fluid" style="height: 100%;width: 100%;"> -->
 <div class="container-fluid" style="height: 100%;">
<!--<div class="container-fluid" style="height: 50%;width: 50%;">-->

	<?php include './php/ayuda.php'; ?>
	<?php include './php/contacto.php'; ?>

	<!-- Mensajes de acciÃ³n -->
	<?php include './php/mensajes.php'; ?>
	<!--Panel de impresion, con dimension y boton de imprimir-->
	<div id="panelImpresion" class="hide" style="display:none">
		<br><<------------------------------------------------------------------------------------------<span class="badge">AREA DE IMPRESION</span>-------------------------------------------------------------------------------------->>
		<button class="btn  btn-md btn-default" onclick="imprSelec('map');" title="Imprimir">Imprimir Plano</button>
		<button class="btn  btn-md btn-default" onclick="cancelarImpresion();" title="Cancelar Impresion">X</button>
	</div>

	<!-- <div id="map" style="z-index: 2;" class="fillme cargando  col-md-12 col-sm-12 col-lg-12" style="display:block"></div><!-- Map -->
	 <!--<div id="map" style="z-index: 2;" class="fillme cargando  col-md-12 col-sm-12 col-lg-12"></div><!-- Map -->
<div id="map" style="z-index: 2;" class="fillme cargando  col-lg-12 col-md-12 col-sm-12'"></div><!-- Map -->


	<script src="./js/jquery/jquery.min.js"></script><!--jQuery -->

	<?php include './php/panelBusqueda.php'; ?>
	<?php include './php/inicioSesion.php'; ?>
	<?php include './php/modalReclamos.php'; ?>
	<?php include './php/modalCambiarPassword.php'; ?>



</div>



<!--Script del mapa-->



<script src="./js/jquery/jquery-ui.min.js"></script><!--jQuery UI-->

 <!--<script src="./js/Leaflet/leaflet.min.js"></script> <!--Leaflet -->

 <!--<script src="//unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet-src.js"></script>
<!--<script src="./js/openlayers/ol.js"></script>--><!--OpenLayers -->


<script src="./js/Leaflet-draw/leaflet.draw.js"></script><!--Leaflet Draw -->
<script src="./js/Leaflet.MousePosition-master/src/L.Control.MousePosition.js"></script><!--Mouse Position -->
<script src="./js/Leaflet-MiniMap-master/src/Control.MiniMap.js"></script><!--Minimap -->
<script src="./js/leaflet.fullscreen/Control.Fullscreen.min.js"></script><!--FullScreen -->
<script src="./js/bootstrap/js/bootstrap.min.js"></script><!--Bootstrap -->
<!--<script src="./js/Leaflet-StyledLayerControl/js/styledLayerControl.js"></script>-->


<script src="./js/Leaflet-StyledLayerControl/js/styledLayerControlv1.js"></script>
<!-- <script src="./js/Leaflet-GroupStyledLayer/leaflet.groupedlayercontrol.js"></script> -->


	<!--Bubble control-->
<script src="./js/L.Control.Basemaps/L.Control.Basemaps.js"></script>
<script src="./js/L.Control.Basemaps/L.MuniControlBasemap.js"></script>




	<!-- GeoComplete-->
	<!--<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places"></script>-->
	<!--<!-<script src="https://maps.googleapis.com/maps/api/js?v=3&libraries=places"></script> -->
	<!-- GeoComplete-->

	<script src="https://maps.googleapis.com/maps/api/js?v=3&libraries=places&key=AIzaSyDrlnLGHYmqrNR3gX7MGA_ELjqKOUCD8Cc"></script>

<!--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script> -->


<!-- Capa google-->
<script src="./js/Google.js"></script>

<!-- Capa google-->
<!--<script src="./js/Leaflet.GridLayer.GoogleMutant/Leaflet.GoogleMutant.js"></script> -->



<script src="./js/jquery.geocomplete.min.js"></script>
<!-- Spinner-->
<script src="./js/spin.min.js"></script>
<script src="./js/spiner.js"></script>
<!-- Formatter para nomenclatura-->
<script src="./js/Formatter/formatter.min.js"></script>
<script src="./js/Formatter/jquery.formatter.min.js"></script>
<script src="./js/tooltips.js"></script>
<!-- LÃ³gica de negocio -->

<script src="./js/leaflet-svgicon-master/svg-icon.js"></script>



	<?php

			if ($__LayerLibrary=="Openlayers"){
					//<!-- OpenLayers -->
				echo '<script src="./js/functionsOL.js"></script>';
			}
			else
			{
				//<!-- Leaflet -->
				echo '<script src="./js/functions.js"></script>';

			}
	?>

<script src="./js/geoUbicacion.js"></script>

<!--<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false"></script>-->

<!-- <script src="./js/placeholders.min.js"></script> PERMITE SIMULAR EL PLACEHOLDER EN versiones IE<9-->

<script>


$(document).click(function(event) {
		if(!$(event.target).closest('#menu-wrapper').length) {
				if($('#menu-wrapper').hasClass("active")) {
						$('#menu-wrapper').toggleClass("active");
						$('#menu-button').toggleClass("active");
				}
		}
})
$(document).ready(function(){
	$('#modoConsulta').click(function(){
		modoMapa(1);
		$(this).parent().addClass('hidden');
		$('#modoDibujo').parent().removeClass('hidden');
		return false;
	});
	$('#modoDibujo').click(function(){
		modoMapa(0);
		$(this).parent().addClass('hidden');
		$('#modoConsulta').parent().removeClass('hidden');
		return false;
	});

	//Para poder hacer click en cualquier lugar del menu y que funcione el correspondiente checkbox
	$(".menu-item-checkbox").on("click",function(e) {
		var checkbox = $(this).find("input[type='checkbox']");
		if (e.target !== this){
			if (checkbox.is(":checked")){
				$(this).addClass('checkedDiv');
			}else{
				$(this).removeClass('checkedDiv');
			}
			return;
		}
		checkbox.trigger('click');
		if (checkbox.is(":checked")){
			$(this).addClass('checkedDiv');
		}else{
			$(this).removeClass('checkedDiv');
		}
	});

	$( "#txtBusqueda" ).focus(function() {
			$(this).prev('.input-group-addon').addClass('addon-focus');
	});

	$( "#txtBusqueda" ).focusout(function() {
			$(this).prev('.input-group-addon').removeClass('addon-focus');
	});
	$(function () {
			$('#menu-button').click(function (e) {
					e.preventDefault();
					$(this).toggleClass("active");
					$("#menu-wrapper").toggleClass("active");
					e.stopPropagation();
			});

	});

	$('#habilitarReclamos').addClass('hide');



//	var _strservicio = '<?php echo $__ServidorDB; ?>';
//	console.log(_strservicio);


	tooltips();
	initialize();

	nombre_user_global = '<?php if(isset($usuario)) echo $usuario; ?>';
    id_user_global =  "<?php if(isset($_SESSION['id_usuario'])) echo $_SESSION['id_usuario'];?>";
    cookie_usuario = "<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email'] ;?>";
    email_user_global="<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email'] ;?>";
	tipo_user_global = '<?php if(isset($tipo_user)) echo $tipo_user; ?>';




	recuperarSesion(nombre_user_global);

	//console.log(id_user_global);
	if (!(id_user_global == ''))
    	notifyMe(nombre_user_global,id_user_global,tipo_user_global);

	$('#habilitarReclamos').addClass('hide');


			if (!((tipo_user_global !=4) && (tipo_user_global !=1))){

					$('#habilitarReclamos').removeClass('hide');
			}




});


</script>
<?php
 //include './php/GuardarInfoVisitante.php';
?>
</body>
</html>
