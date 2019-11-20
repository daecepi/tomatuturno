<?php
 include_once 'bibliotecaPHP.php';

 $codigo= $_POST['codigo'];
 $pass= $_POST['pass'];

 echo recuperaTurno($codigo,$pass);
?>
