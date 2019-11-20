<?php
  include_once 'assets/php/bibliotecaPHP.php';
  function adiciona(){

    $host = "localhost";
    $usuario = "root";
    $password = "";
    $BaseDatos = "pide_turno";

        $link=mysql_connect($host,$usuario,$password);

    mysql_select_db($BaseDatos,$link);

    $consultaSQL= "SELECT estado_programas.programa FROM estado_programas WHERE 1;";
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

      echo ($retorno[27][programa]);
      $file = fopen("programas2.txt", "a");
      for ($i=0; $i < count($retorno); $i++) {
        fwrite($file, "vecPal.push(\"".$retorno[$i]['programa']."\");" . PHP_EOL);
      }


      fclose($file);
    }
    adiciona();
?>
