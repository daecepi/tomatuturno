<?php
	include_once 'assets/php/bibliotecaPHP.php';
	$registros = arrayProgramas();
	$msj = false;
	if (isset ($_POST['user'])){
		$us = $_POST['user'];
		$pa = $_POST['pass'];
		for ($i=0; $i<count($registros); $i++){
			if ($registros[$i]['user'] == $us && $registros[$i]['pass'] == $pa){
				session_start();
				$_SESSION['programa'] = $registros[$i]['programa'];
				$_SESSION['codigo'] = $registros[$i]['codigo'];
				$_SESSION['fecha'];
				header('Location: assets/admin/index.php');
			}
		}
		$msj = true;
	}
?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>LOGIN TomaTuTurno</title>
        <link rel="stylesheet" href="assets/css/stylelogin.css">
	<script>
		function formulario(f) {
		if (f.user.value   == '') {
			alert ('El campo Usuario está vacío');
			f.user.focus(); return false; }
		if (f.pass.value  == '') {
			alert ('El campo Contraseña está vacío');
			f.pass.focus(); return false; }
			return true; }
	</script>
  </head>

  <body>

    <div class="login-page">
  <div class="form">

    <form class="login-form" action="login.php" name="login" onsubmit="return formulario(this)" method="post">
      <input type="text" placeholder="Usuario" name="user" value="<?php if (isset($us)){echo $us;}?>"/>
      <input type="password" placeholder="Contrase&ntilde;a" name="pass"/>
      <button>login</button>
	  <?php
	  if ($msj == true){ echo '<p class="message"><font color="red">*Usuario o contrase&ntilde;a inv&aacute;lida</font></p>'; }
	  ?>
      <p class="message">Olvido su clave? Contacte con administrador</p>
    </form>
  </div>
</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="assets/js/login.js"></script>

  </body>
</html>
