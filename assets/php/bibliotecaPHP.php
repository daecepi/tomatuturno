<?php
function agregaColaEstudiante ($cod, $nom, $carr, $pass){ //agrega un estudiante a la BD de turnos
	$paraCodigo = '/^[0-9]+$/';
	$paraNombre = '/^[a-zA-Z_áéíóúñ\s.]*$/';
	$paraContraseña = '/^[0-9a-zA-Z_áéíóúñ\s]*$/';

	$cod = stripslashes($cod);
	$cod = mysql_real_escape_string($cod);
	$cod = htmlspecialchars($cod);

	$nom = stripslashes($nom);
	$nom = mysql_real_escape_string($nom);
	$nom = htmlspecialchars($nom);

	$carr = stripslashes($carr);
	$carr = mysql_real_escape_string($carr);
	$carr = htmlspecialchars($carr);

	$pass = stripslashes($pass);
	$pass = mysql_real_escape_string($pass);
	$pass = htmlspecialchars($pass);

	$mensaje = turnosDisponibles($carr);

	if(carreraExiste($carr) != 1){
		return "Mensaje:Error programa no existe.";
	}else if ($cod == "" || $cod == " " || $cod == null) {
		return "Mensaje:Codigo de estudiante suministrado no valido.";
	}else if ($pass == "" || $pass == " " || $pass == null) {
		return "Mensaje:Las contraseñas suministradas solo contienen letras y/o numeros.";
	}else	if (preg_match($paraCodigo, $cod) != 1) {
		return "Mensaje:Las contraseñas suministradas solo contienen letras y/o numeros.";
	}else if (preg_match($paraNombre, $nom) != 1) {
		return "Mensaje:Los nombre no llevan numeros.";
	}else if(preg_match($paraContraseña, $pass) != 1){
		return "Mensaje:Codigo de estudiante suministrado no valido.";
	}else	if ($mensaje == "Bien") {
			$host = "localhost";
			$usuario = "root";
			$password = "";
			$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);
			mysql_select_db($BaseDatos,$link);
			$consultaSQL = "INSERT INTO turnos (codigo, nombre, carrera, clave, estado) VALUES ('$cod', '$nom', '$carr', '$pass', 'No atendido')";
			mysql_query("SET NAMES utf8");
			if (mysql_query($consultaSQL,$link)) {
				$result ="Mensaje:Turno agregado satisfactoriamente.";
			}else{
				$result ="Mensaje:El codigo que menciona ya tiene un turno.";
			}
			mysql_close($link);
			return $result;
		}else{
			return $mensaje;
		}
	return "Mensaje:Problema al contactar con el servidor, espere un momento y actualice la página o verifique su conexión a internet.";
}

function turnosDisponibles($carr){
	$host = "localhost";
	$usuario = "root";
	$password = "";
	$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);

	mysql_select_db($BaseDatos,$link);
	$retorno = array();
	$consultaSQL = "SELECT estado_programas.estado, estado_programas.turnos_atendidos, estado_programas.turnos_manana, estado_programas.turnos_tarde FROM estado_programas WHERE estado_programas.codigo='$carr';";
	mysql_query("SET NAMES utf8");
	$result = mysql_query($consultaSQL);
	for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
		for($a= 0;$a<mysql_num_fields($result);$a++){
			$campo = mysql_field_name($result,$a);
			$retorno[$i][$campo] = $fila[$campo];
		}
	}

	mysql_close($link);
	if($retorno[0]['estado'] != "activo"){
		return "Mensaje:El programa en el que quiere pedir un turno todavia no esta matriculando.";
	}
	if (!($retorno[0]['turnos_manana']=='Los que se pueda' || ($retorno[0]['turnos_atendidos']=='Los que se pueda'))) {
		$atendidos = intval($retorno[0]['turnos_atendidos']);
		$manana =intval($retorno[0]['turnos_manana']);
		$tarde = intval($retorno[0]['turnos_tarde']);
		$recorrer = arrayCuentaTurnos();
		for ($i=0; $i < count($recorrer); $i++) {
			if ($recorrer[$i]['carrera'] == $carr) {
				$enCola = $recorrer[$i]['numero'];
				if(($atendidos+$enCola) <= ($tarde+$manana)){
					return "Bien";
				}else{
					return "Mensaje:Los turnos se han agotado para esta carrera.";
				}
			}
		}
	}
	return "Bien";
}

function recuperaTurno($codigo,$pass){
	$paraCodigo = '/^[0-9]+$/';
	$paraContraseña = '/^[0-9a-zA-Z_áéíóúñ\s]*$/';

	$codigo = stripslashes($codigo);
	$codigo = mysql_real_escape_string($codigo);
	$codigo = htmlspecialchars($codigo);

	$pass = stripslashes($pass);
	$pass = mysql_real_escape_string($pass);
	$pass = htmlspecialchars($pass);

	if ($codigo == "" || $codigo == " " || $codigo == null) {
		return "Mensaje:Codigo de estudiante suministrado no valido.";
	}if ($pass == "" || $pass == " " || $pass == null) {
		return "Mensaje:Las contraseñas suministradas solo contienen letras y/o numeros.";
	} else	if (preg_match($paraContraseña, $pass) != 1) {
		return "Mensaje:Las contraseñas suministradas solo contienen letras y/o numeros.";
	} else if(preg_match($paraCodigo, $codigo) != 1){
		return "Mensaje:Codigo de estudiante suministrado no valido.";
	}else{
	  $host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

				$link=mysql_connect($host,$usuario,$password);

		mysql_select_db($BaseDatos,$link);
		$retorno = array();
		$consultaSQL = "SELECT turnos.estado FROM turnos WHERE turnos.codigo='$codigo' AND turnos.clave='$pass';";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
			for($a= 0;$a<mysql_num_fields($result);$a++){
				$campo = mysql_field_name($result,$a);
				$retorno[$i][$campo] = $fila[$campo];
			}
		}
		if (empty($retorno)) {
			return "Mensaje:Combinación de turno y clave incorrecta, el turno que menciona no se encuentra en cola.";
		}
	    if($retorno[0]['estado']=="No atendido"){
	     return "Mensaje:turno encontrado y agregado satisfactoriamente.";
	    }else{
	     return "Mensaje:Problema al contactar con el servidor, espere un momento y actualice la página o verifique su conexión a internet.";
	    }
	}
}

function verificaTurno($codigo,$pass){
	$paraCodigo = '/^[0-9]+$/';
	$paraContraseña = '/^[0-9a-zA-Z_áéíóúñ\s]*$/';

	$codigo = stripslashes($codigo);
	$codigo = mysql_real_escape_string($codigo);
	$codigo = htmlspecialchars($codigo);

	$pass = stripslashes($pass);
	$pass = mysql_real_escape_string($pass);
	$pass = htmlspecialchars($pass);

	if ($codigo == "" || $codigo == " " || $codigo == null) {
		return "Mensaje:Codigo de estudiante suministrado no valido.";
	}if ($pass == "" || $pass == " " || $pass == null) {
		return "Mensaje:Las contraseñas suministradas solo contienen letras y/o numeros.";
	} else	if (preg_match($paraContraseña, $pass) != 1) {
		return "Mensaje:Las contraseñas suministradas solo contienen letras y/o numeros.";
	} else if(preg_match($paraCodigo, $codigo) != 1){
		return "Mensaje:Codigo de estudiante suministrado no valido.";
	}else{
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

				$link=mysql_connect($host,$usuario,$password);

		mysql_select_db($BaseDatos,$link);
		$retorno = array();
		$consultaSQL = "SELECT turnos.estado  FROM turnos WHERE turnos.codigo='$codigo' AND turnos.clave='$pass';";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
			for($a= 0;$a<mysql_num_fields($result);$a++){
				$campo = mysql_field_name($result,$a);
				$retorno[$i][$campo] = $fila[$campo];
			}
		}
		if (empty($retorno)) {
			return "Mensaje:Contraseña errada.";
		}else if($retorno[0]['estado'] == "Atendido" || $retorno[0]['estado'] == "No atendido"){
			return "Mensaje:El turno ha sido eliminado de esta pagina satisfactoriamente.";
		}else{
			return "Mensaje:Problema al contactar con el servidor, espere un momento y actualice la página o verifique su conexión a internet.";
		}
	}
}

function calculaTiempo($carrera){
	if(!isset($_SESSION['fecha'])){
		$_SESSION['fecha']=strtotime('now');
	}else{
		$fechaActual = strtotime('now');
		$segundos = $fechaActual - strtotime(date('Y-m-d H:i:s',$_SESSION['fecha']));
		$_SESSION['fecha']=$fechaActual;
		nuevoTiempo((($segundos+tiempoGuardado($carrera))/2), $carrera);
	}
 }

function nuevoTiempo($tiempo, $carrera){
 $host = "localhost";
 $usuario = "root";
 $password = "";
 $BaseDatos = "pide_turno";

 $link=mysql_connect($host,$usuario,$password);
 mysql_select_db($BaseDatos,$link);
 $consultaSQL = "UPDATE estado_programas SET segundos_espera=$tiempo WHERE codigo='$carrera';";

 if (mysql_query($consultaSQL,$link)) {
	 $result ="Tiempo adaptado satisfactoriamente.";

 }else{
	 $result ="Hubo una falla de conexión.";
 }
}

function tiempoGuardado($carrera){
	$host = "localhost";
	$usuario = "root";
	$password = "";
	$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);

	mysql_select_db($BaseDatos,$link);
	$retorno = array();
	$consultaSQL = "SELECT estado_programas.segundos_espera FROM estado_programas WHERE codigo='$carrera';";
	mysql_query("SET NAMES utf8");
	$result = mysql_query($consultaSQL);
	for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
		for($a= 0;$a<mysql_num_fields($result);$a++){
			$campo = mysql_field_name($result,$a);
			$retorno[$i][$campo] = $fila[$campo];
		}
	}
	mysql_close($link);

	return $retorno[0]['segundos_espera'];
}

function eliminarDeCola($codigo, $pass){
	$paraCodigo = '/^[0-9]+$/';
	$paraContraseña = '/^[0-9a-zA-Z_áéíóúñ\s]*$/';

	$codigo = stripslashes($codigo);
	$codigo = mysql_real_escape_string($codigo);
	$codigo = htmlspecialchars($codigo);

	$pass = stripslashes($pass);
	$pass = mysql_real_escape_string($pass);
	$pass = htmlspecialchars($pass);

	if ($codigo == "" || $codigo == " " || $codigo == null) {
		return "Mensaje:Codigo de estudiante suministrado no valido.";
	}if ($pass == "" || $pass == " " || $pass == null) {
		return "Mensaje:Las contraseñas suministradas solo contienen letras y/o numeros.";
	} else	if (preg_match($paraContraseña, $pass) != 1) {
		return "Mensaje:Las contraseñas suministradas solo contienen letras y/o numeros.";
	} else if(preg_match($paraCodigo, $codigo) != 1){
		return "Mensaje:Codigo de estudiante suministrado no valido.";
	}else{
		if(turnoNoExiste($codigo) == 1){
			return "Mensaje:El turno que menciona no existe o ya no esta en cola.";
		}else if(passEquivocada($codigo, $pass) == 1){
			return $codigo." ".$pass; //"La contraseña del turno esta equivocada"
		}else{
			$host = "localhost";
			$usuario = "root";
			$password = "";
			$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);
			mysql_select_db($BaseDatos,$link);
			$consultaSQL = "DELETE FROM turnos WHERE turnos.codigo='$codigo' AND turnos.clave='$pass';";
			mysql_query("SET NAMES utf8");
			if (mysql_query($consultaSQL,$link)) {
				$result ="Mensaje:Turno eliminado satisfactoriamente.";

			}else{
				$result ="Mensaje:Problema de conexión, intentelo nuevamente.";
			}

			mysql_close($link);
			return $result;
		}
	}
}

function passEquivocada($codigo, $pass){
	$host = "localhost";
	$usuario = "root";
	$password = "";
	$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);

	mysql_select_db($BaseDatos,$link);
	$retorno = array();
	$consultaSQL = "SELECT turnos.nombre FROM turnos WHERE turnos.codigo='$codigo' AND turnos.clave='$pass';";
	mysql_query("SET NAMES utf8");
	$result = mysql_query($consultaSQL);
	for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
		for($a= 0;$a<mysql_num_fields($result);$a++){
			$campo = mysql_field_name($result,$a);
			$retorno[$i][$campo] = $fila[$campo];
		}
	}
	mysql_close($link);
	$respuesta =empty($retorno);
	return $respuesta;
}

function turnoNoExiste($codigo){
	$host = "localhost";
	$usuario = "root";
	$password = "";
	$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);

	mysql_select_db($BaseDatos,$link);
	$retorno = array();
	$consultaSQL = "SELECT turnos.nombre FROM turnos WHERE turnos.codigo='$codigo';";
	mysql_query("SET NAMES utf8");
	$result = mysql_query($consultaSQL);
	for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
		for($a= 0;$a<mysql_num_fields($result);$a++){
			$campo = mysql_field_name($result,$a);
			$retorno[$i][$campo] = $fila[$campo];
		}
	}
	mysql_close($link);
	$respuesta =empty($retorno);
	return $respuesta;
}

function configurarColaCarrera ($carrera, $estado, $jmanana, $jtarde, $coment){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);
			mysql_select_db($BaseDatos,$link);
			$consultaSQL = "UPDATE estado_programas SET estado='$estado', turnos_manana='$jmanana', turnos_tarde='$jtarde', Comentarios='$coment' WHERE codigo='$carrera'";
			mysql_query("SET NAMES utf8");
			$result = mysql_query($consultaSQL);
			mysql_close($link);

			return $result;
	}

function carreraExiste($carr){
	$host = "localhost";
	$usuario = "root";
	$password = "";
	$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);

	mysql_select_db($BaseDatos,$link);
	$retorno = array();
	$consultaSQL = "SELECT estado_programas.codigo, COUNT(*) AS 'existe' FROM estado_programas WHERE estado_programas.codigo='$carr';";
	mysql_query("SET NAMES utf8");
	$result = mysql_query($consultaSQL);
	for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
		for($a= 0;$a<mysql_num_fields($result);$a++){
			$campo = mysql_field_name($result,$a);
			$retorno[$i][$campo] = $fila[$campo];
		}
	}
	mysql_close($link);
	$respuesta =$retorno[0]['existe'];
	return $respuesta;
}

function estudianteAtendido ($carrera){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);
			mysql_select_db($BaseDatos,$link);
			$consulta1 = "SELECT * FROM turnos WHERE carrera = '$carrera' AND estado='No atendido' LIMIT 1";
			mysql_query("SET NAMES utf8");
			$comprueba = mysql_query($consulta1);
			if (mysql_num_rows($comprueba)>0){
				$consultaSQL = "UPDATE turnos SET estado='atendido' WHERE carrera = '$carrera' AND estado='No atendido' ORDER BY guia LIMIT 1";
				$result = mysql_query($consultaSQL);
				mysql_query("UPDATE estado_programas SET turnos_atendidos=turnos_atendidos+1 WHERE codigo = '$carrera'");
				mysql_close($link);

				return $result;
			} else {
				mysql_close($link);
				return false;
			}
	}

	function vectorProgramas (){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

			$link=mysql_connect($host,$usuario,$password);
			mysql_select_db($BaseDatos,$link);
			$consultaSQL = "SELECT estado_programas.programa FROM estado_programas";
			mysql_query("SET NAMES utf8");
			$result = mysql_query($consultaSQL);
			for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
				for($a= 0;$a<mysql_num_fields($result);$a++){
					$campo = mysql_field_name($result,$a);
					$retorno[$i][$campo] = $fila[$campo];
				}
			};
			mysql_close($link);

			return $retorno;
	}

		function arrayColaEstudiantes (){ //devuelve array con todos los estudiantes en cola con: codigo, nombre y carrera(codigo)
			$host = "localhost";
			$usuario = "root";
			$password = "";
			$BaseDatos = "pide_turno";

	        $link=mysql_connect($host,$usuario,$password);

			mysql_select_db($BaseDatos,$link);
			$retorno = array();
			$consultaSQL = "SELECT turnos.codigo, turnos.nombre, turnos.carrera FROM turnos WHERE turnos.estado='No atendido' ORDER BY guia;";
			mysql_query("SET NAMES utf8");
			$result = mysql_query($consultaSQL);
			for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
				for($a= 0;$a<mysql_num_fields($result);$a++){
					$campo = mysql_field_name($result,$a);
					$retorno[$i][$campo] = $fila[$campo];
				}
			};
			mysql_close($link);

			return $retorno;
		}

	function arrayCuentaTurnos(){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

        $link=mysql_connect($host,$usuario,$password);

		mysql_select_db($BaseDatos,$link);
		$retorno = array();
		$consultaSQL = "SELECT turnos.carrera, COUNT(*) AS numero  FROM turnos WHERE turnos.estado='No atendido' GROUP BY turnos.carrera;";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
			for($a= 0;$a<mysql_num_fields($result);$a++){
				$campo = mysql_field_name($result,$a);
				$retorno[$i][$campo] = $fila[$campo];
			}
		};
		mysql_close($link);

		return $retorno;
	}

	function arrayProgramas (){ //devuleve array con todos los programas de la universidad con: codigo, estado, programa y comentarios
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

        $link=mysql_connect($host,$usuario,$password);

		mysql_select_db($BaseDatos,$link);

		$consultaSQL = "SELECT estado_programas.codigo, estado_programas.estado, estado_programas.programa, estado_programas.user, estado_programas.pass, estado_programas.comentarios FROM estado_programas;";
		$retorno =array();
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
			for($a= 0;$a<mysql_num_fields($result);$a++){
				$campo = mysql_field_name($result,$a);
				$retorno[$i][$campo] = $fila[$campo];
			}
		};
		mysql_close($link);

		return $retorno;
	}

	function infoPrograma ($cod){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

		$link=mysql_connect($host,$usuario,$password);
		mysql_select_db($BaseDatos,$link);
		$consultaSQL = "SELECT * FROM estado_programas WHERE codigo = '$cod'";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		$retorno = mysql_fetch_assoc ($result);

		mysql_close($link);

		return $retorno;
	}

	function cambPass ($cod, $pass, $passNew){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

		$link=mysql_connect($host,$usuario,$password);
		mysql_select_db($BaseDatos,$link);
		$consultaSQL = "SELECT * FROM estado_programas WHERE codigo = '$cod' AND pass = '$pass'";
		mysql_query("SET NAMES utf8");
		$result = mysql_num_rows(mysql_query($consultaSQL));
		mysql_close($link);
		if ($result == 0){
			return false;
		}else{
			$link2=mysql_connect($host,$usuario,$password);
			mysql_select_db($BaseDatos,$link2);
			$consultaSQL2 = "UPDATE estado_programas SET pass = '$passNew' WHERE codigo = '$cod'";
			$result2 = mysql_query($consultaSQL2);
			mysql_close($link2);
			return $result2;
		}
	}

	function colaCarrera ($carrera){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

		$link=mysql_connect($host,$usuario,$password);
		mysql_select_db($BaseDatos,$link);
		$consultaSQL = "SELECT * FROM turnos WHERE turnos.carrera = '$carrera' AND turnos.estado='No atendido' ORDER BY guia";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		$retorno;
		for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
			for($a= 0;$a<mysql_num_fields($result);$a++){
				$campo = mysql_field_name($result,$a);
				$retorno[$i][$campo] = $fila[$campo];
			}
		}
		mysql_close($link);
		if (mysql_num_rows($result)>0){
			return $retorno;
		} else {
			return array();
		}
	}

	function numColaPendientes ($codigo){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

        $link=mysql_connect($host,$usuario,$password);

		mysql_select_db($BaseDatos,$link);
		$consultaSQL = "SELECT COUNT(*) FROM turnos WHERE carrera = '$codigo' AND turnos.estado='No atendido'";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		$valor = mysql_fetch_array($result);
		mysql_close($link);
		return $valor[0];
	}

	function arrayTurnosCola (){ //devuleve array con todos los programas de la universidad con: codigo, estado, programa y comentarios
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

        $link=mysql_connect($host,$usuario,$password);

		mysql_select_db($BaseDatos,$link);

		$consultaSQL= "SELECT estado_programas.programa, estado_programas.Comentarios, estado_programas.turnos_atendidos, estado_programas.codigo, estado_programas.turnos_manana, estado_programas.turnos_tarde, estado_programas.segundos_espera, estado_programas.estado FROM estado_programas GROUP BY estado_programas.programa";
		$retorno ="";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
			for($a= 0;$a<mysql_num_fields($result);$a++){
				$campo = mysql_field_name($result,$a);
				$retorno[$i][$campo] = $fila[$campo];
			}
		};
		mysql_close($link);

		return $retorno;
	}

	function limpiaTablaTurnos ($carrera){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

        $link=mysql_connect($host,$usuario,$password);

		mysql_select_db($BaseDatos,$link);

		$consultaSQL = "DELETE FROM turnos WHERE carrera='$carrera'";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		mysql_query("UPDATE estado_programas SET turnos_atendidos='0' WHERE codigo = '$carrera'");
		mysql_close($link);
		return $result;
	}

	function listaColaPorCarrera(){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

        $link=mysql_connect($host,$usuario,$password);

		mysql_select_db($BaseDatos,$link);

		$consultaSQL = "SELECT turnos.carrera, COUNT(*) AS enEspera FROM turnos WHERE turnos.estado='No atendido' GROUP BY turnos.carrera;";
		$retorno ="";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
			for($a= 0;$a<mysql_num_fields($result);$a++){
				$campo = mysql_field_name($result,$a);
				$retorno[$i][$campo] = $fila[$campo];
			}
		};
		mysql_close($link);

		return $retorno;
	}

	function colaCarreraAtendida ($carrera){
		$host = "localhost";
		$usuario = "root";
		$password = "";
		$BaseDatos = "pide_turno";

		$link=mysql_connect($host,$usuario,$password);
		mysql_select_db($BaseDatos,$link);
		$consultaSQL = "SELECT * FROM turnos WHERE carrera = '$carrera' AND estado='atendido' ORDER BY guia";
		mysql_query("SET NAMES utf8");
		$result = mysql_query($consultaSQL);
		for($i=0;$fila= mysql_fetch_assoc($result); $i++) {
			for($a= 0;$a<mysql_num_fields($result);$a++){
				$campo = mysql_field_name($result,$a);
				$retorno[$i][$campo] = $fila[$campo];
			}
		};
		mysql_close($link);

		return $retorno;
	}

	function generarClave(){
       $cadena="[^A-Z0-9]";
       return substr(eregi_replace($cadena, "", md5(rand())) .
       eregi_replace($cadena, "", md5(rand())) .
       eregi_replace($cadena, "", md5(rand())),
       0, 5);
	}

	function enviaEmail ($destino, $nom, $clave){
		$titulo = 'Clave de la cola para matrícula';
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: TomaTuTurno <no-reply@tomatuturno.com>' . "\r\n";
		$mensaje = '<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>A Simple Responsive HTML Email</title>
  <style type="text/css">
  body {margin: 0; padding: 0; min-width: 100%!important;}
  img {height: auto;}
  .content {width: 100%; max-width: 600px;}
  .header {padding: 40px 30px 20px 30px;}
  .innerpadding {padding: 30px 30px 30px 30px;}
  .borderbottom {border-bottom: 1px solid #f2eeed;}
  .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
  .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
  .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
  .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
  .bodycopy {font-size: 16px; line-height: 22px;}
  .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
  .button a {color: #ffffff; text-decoration: none;}
  .footer {padding: 20px 30px 15px 30px;}
  .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
  .footercopy a {color: #ffffff; text-decoration: underline;}

  @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
  body[yahoo] .hide {display: none!important;}
  body[yahoo] .buttonwrapper {background-color: transparent!important;}
  body[yahoo] .button {padding: 0px!important;}
  body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
  body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
  }

  /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/

  </style>
</head>

<body yahoo bgcolor="#f6f8f1">
<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>

    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td bgcolor="#F78181" class="header">
          <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="70" style="padding: 0 20px 20px 0;">
                <img class="fix" src="https://s9.postimg.org/3ono1wym7/correogmailiniciarsesion_com_favicon.png" width="70" height="70" border="0" alt="" />
              </td>
            </tr>
          </table>

          <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 425px;">
            <tr>
              <td height="70">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="subhead" style="padding: 0 0 0 3px;">
                      Universidad de Cartagena
                    </td>
                  </tr>
                  <tr>
                    <td class="h1" style="padding: 5px 0 0 0;">
                      Toma tu turno
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

        </td>
      </tr>
      <tr>
        <td class="innerpadding borderbottom">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="h2">
                '.$nom.' Gracias por usar nuestro servicio!
              </td>
            </tr>
            <tr>
              <td class="bodycopy">

              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="innerpadding borderbottom">
          <table width="115" align="left" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="115" style="padding: 0 20px 20px 0;">
                <img class="fix" src="https://s21.postimg.org/9jcfk9h9z/article1.png" width="115" height="115" border="0" alt="" />
              </td>
            </tr>
          </table>

          <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 380px;">
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="bodycopy">
						Se te ha a&ntilde;adido correctamente a la cola.<br>
						Clave : '.$clave.'
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 20px 0 0 0;">
                      <table class="buttonwrapper" bgcolor="#e05443" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="button" height="45">
                            <a href="#">Ver estado de la cola</a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

        </td>
      </tr>
      <tr>

      </tr>
      <tr>
        <td class="innerpadding bodycopy">
          La clave de su turno es necesaria para poder realizar cancelacion o posponer su turno 10 puestos atr&aacute;s en caso de ser requerido.
        </td>
      </tr>
      <tr>
        <td class="footer" bgcolor="#44525f">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" class="footercopy">
                &reg; TomaTuTurno, Bolívar, Cartagena 2016<br/>
              </td>
            </tr>
            <tr>
              <td align="center" style="padding: 20px 0 0 0;">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="#">
                        <img src="https://s13.postimg.io/tugfjaw7r/image_07.png" width="37" height="37" alt="Facebook" border="0" />
                      </a>
                    </td>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="http://www.unicartagena.edu.co">
                        <img src="https://s10.postimg.org/u3wiwqsw9/cartagena.gif" width="37" height="37" alt="Twitter" border="0" />
                      </a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    </td>
  </tr>
</table>

<!--analytics-->
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://tutsplus.github.io/github-analytics/ga-tracking.min.js"></script>
</body>
</html>';
		mail($destino, $titulo, $mensaje, $cabeceras);
	}

	?>
