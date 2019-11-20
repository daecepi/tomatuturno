<!DOCTYPE html>
<html>
	<?php
		session_start ();
		if (!isset($_SESSION['programa'])){
			header('Location: logout.php');
		}
		$programa = $_SESSION['programa'];
		$codigo = $_SESSION['codigo'];
		include_once '../php/bibliotecaPHP.php';
		$numCola = numColaPendientes ($codigo);
	?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Bienvenido</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Preloader Css -->
    <link href="plugins/material-design-preloader/md-preloader.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
	
	<script type="text/javascript">
            function funcionPHP() {
                location.href="admincola.php?atiende=atendido";
            }
    </script>
	
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="md-preloader pl-size-md">
                <svg viewbox="0 0 75 75">
                    <circle cx="37.5" cy="37.5" r="33.5" class="pl-red" stroke-width="4" />
                </svg>
            </div>
            <p>Por favor espere...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">t3 - JEFES DE DEPARTAMENTO</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">

                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count"><?php echo $numCola; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICACIONES</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="admincola.php">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><?php echo $numCola; ?> Estudiantes en cola</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i>a las <?php ini_set('date.timezone','America/Bogota'); echo date("g:i A");?>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                
                                </ul>
                            </li>
                            
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                  <img src="images/userDos.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $programa; ?></div>
                    <div class="email">Jefe De partamento</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                       
                            <li role="seperator" class="divider"></li>
                            <li><a href="configuser.php"><i class="material-icons">brightness_high</i>Contraseña</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="logout.php"><i class="material-icons">input</i>Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MEN&Uacute; PRINCIPAL</li>
                    <li>
                        <a href="index.php">
                            <i class="material-icons">home</i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="admincola.php">
                            <i class="material-icons">event_note</i>
                            <span>Administrar Cola</span>
                        </a>
                    </li>
                    <li>
                        <a href="configuser.php">
                            <i class="material-icons">person_pin</i>
                            <span>Configuraciones de usuario</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="configcola.php">
                            <i class="material-icons">group</i>
                            <span>Configurar opciones de cola</span>
                        </a>
                    </li>
					<li>
                        <a href="historialcola.php">
                            <i class="material-icons">history</i>
                            <span>Historial de la cola</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2016 <a href="javascript:void(0);">TomaTuTurno - All rights reserved.</a>.
                </div>
                <div class="version">
                    <b>Versi&oacute;n: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
     
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>OPCIONES GENERALES</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" onclick="funcionPHP()">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content">
                            <div class="text .font-bold"><h4>PASAR TURNO</h4></div>
                        </div>
                    </div>
                </div>
                <a href="https://youtu.be/5v2No41RX-U" target="NUEVA">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">help</i>
                        </div>
                        <div class="content">
                            <div class="text"><h4>TUTORIAL DE USO</h4></div>
                            <div class="text">De esta plataforma</div>
                        </div>
                    </div>
                </div>
				</a>
                <div onclick="window.location ='configcola.php';" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="content">
                            <div class="text"><h4>COMENTARIOS DE MATR&Iacute;CULA</h4></div>
                        </div>
                    </div>
                </div>
                <div onclick="window.location ='configuser.php';" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text"><h4>VER MI USUARIO</h4></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            
							<?php
								if (isset($_POST['oculto'])){
									$resp = limpiaTablaTurnos ($codigo);
									if ($resp == false){
										echo '<div class="alert alert-warning">';
										echo '<strong>Ha ocurrido un error!</strong> No se han podido eliminar los registros';
										echo '</div>';
									}else{
										echo '<div class="alert alert-success">';
										echo '<strong>Muy Bien!</strong> Los registros se han eliminado correctamente';
										echo '</div>';
									}
								}
							?>
							
							<?php
								if (isset($_POST['estado']) || isset($_POST['check']) || isset($_POST['comentarios']) || isset($_POST['jmanana']) || isset($_POST['jtarde'])){
									$estado; $jmanana; $jtarde; $coment = $_POST['comentarios'];
									if (isset($_POST['estado'])){
										$estado = "activo";
									}else{
										$estado = "inactivo";
									}
									
									if (isset($_POST['check'])){
										$jmanana = "Los que se pueda";
										$jtarde = "Los que se pueda";
									}else{
										$jmanana = $_POST['jmanana'];
										$jtarde = $_POST['jtarde'];
									}
									
									$resp2 = configurarColaCarrera ($codigo, $estado, $jmanana, $jtarde, $coment);
									if ($resp2 == false){
										echo '<div class="alert alert-warning">';
										echo '<strong>Ha ocurrido un error!</strong> No se ha podido guardar los cambios';
										echo '</div>';
									}else{
										echo '<div class="alert alert-success">';
										echo '<strong>Muy Bien!</strong> Los cambios se han guardado correctamente';
										echo '</div>';
									}
								}
							?>
							
							<?php $inf = infoPrograma ($codigo); ?>
			
			
			            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                OPCIONES DE LA COLA
                                <small>Guarde los cambios para que tengan efecto</small>
                            </h2>
                        </div>
                        <div class="body">
							<h2 class="card-inside-title">
                                Reinicio de cola
								<small>Debe saber que si realiza esta acci&oacute;n se borraran todos los estudiantes en cola</small>
                            </h2>
							
							<form action="configcola.php" method="post">
							<div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
								<input type="hidden" name="oculto" value="ok">
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">REINICIAR</button>
                            </div>
                            </form>
                            <h2 class="card-inside-title">
                                Estado de la cola
                            </h2>
							
							
							<form action="configcola.php" method="post">
                            <div class="demo-switch">
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="switch">
                                            <label>DESACTIVADA<input type="checkbox" name="estado" <?php if ($inf['estado']=="activo"){echo "checked";}?>><span class="lever switch-col-red"></span>ACTIVADA</label>
                                        </div>
                                    </div> 
                                </div>
                            </div>
							<h2 class="card-inside-title">
                                N&uacute;mero de turnos para atender
                                <small>Ingrese 0 (cero) En el caso de que no atender&aacute; en la jornada</small>
							</h2>
							<input type="checkbox" id="md_checkbox_21" class="filled-in chk-col-red" name="check" onchange="javascript:showContent()" <?php if ($inf['turnos_manana']=="Los que se pueda" && $inf['turnos_tarde']=="Los que se pueda"){echo "checked";}?>/>
                            <label for="md_checkbox_21">INDEFINIDOS</label>
							<div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line" id="content1" style="display">
											<label for="md_checkbox_21">Jornada de la ma&ntilde;ana</label>
                                            <input type="text" class="form-control" name="jmanana" value="<?php echo $inf['turnos_manana']; ?>"/>
                                        </div>
                                    </div>
                            </div>
							<div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line" id="content2" style="display">
											<label for="md_checkbox_21">Jornada de la tarde</label>
                                            <input type="text" class="form-control" name="jtarde" value="<?php echo $inf['turnos_tarde']; ?>"/>
                                        </div>
                                    </div>
                            </div>
							<br><br><br><br>
							<h2 class="card-inside-title">Comentario
							<small>Escriba alg&uacute;n comentario que aparecer&aacute; en la p&aacute;gina principal</small>
							</h2>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="textarea" rows="4" class="form-control no-resize" name="comentarios" value="<?php echo $inf['Comentarios']; ?>"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
                                    
                                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">GUARDAR CAMBIOS</button>
                                   
                            </form>
                        </div>
                    </div>
                </div>
            </div>
			
			
           
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
	<script type="text/javascript">
    function showContent() {
        element1 = document.getElementById("content1");
		element2 = document.getElementById("content2");
        check = document.getElementById("md_checkbox_21");
        if (check.checked) {
           element1.style.display='none';
			element2.style.display='none'; 
        }
        else {
			element1.style.display='block';
			element2.style.display='block';
        }
    }
</script>
</body>

</html>
