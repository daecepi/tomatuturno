<?php
    require_once "lib/nusoap.php";

      $wsdl="http://localhost/ejemplows/serverUser.php?wsdl";
      $serviciosUser = new nusoap_client($wsdl,true);
  $result = $serviciosUser->call("getIds",array());
    $error = $serviciosUser->getError();

?>

<html>
<head>
	<meta charset="utf-8">
	<title>Lista de ID'S</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<style type="text/css">
		#frm{
			position: absolute;
			left: 3%;
			font-size: 14pt;
		}
		hr{
			border-style: solid;
			border-width: 2px;
			border-color: black;
		}
	</style>
</head>
<body>
<div id="frm">
	<h1>Lista de ID'S</h1>
	<H3>Seleccione el id de dispositivo y escriba un msj</H3>
<hr>
<form method="POST" action="enviarmsj.php">
	<?php
	    if ($error) {
        echo json_encode(array('res' => 'nosssss', 'err:'=> $error));
    }
    else{
       	foreach ($result as $clave => $valor) {
       		foreach ($valor as $k => $val){
       			//var_dump($val['id']);
       			echo "<input type=\"checkbox\" name=\"listaid[]\" value=\"".$val['id']."\">".$val['id']."<br>"; 

       		}
     }
    }
	?>
	<br>
<input type="text" name="msj" class="form-control lg" placeholder="Escriba un mensaje">
<button class="btn btn-primary lg">ENVIAR</button>
</form>
<hr>
</div>
</body>
</html>