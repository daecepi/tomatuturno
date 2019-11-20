<?php
  include_once 'bibliotecaPHP.php';

  if ($_POST['estado']=="verificar") {
    echo verificaTurno($_POST['codigo'], $_POST['pass']);
  }else if($_POST['estado']=="eliminar"){
    echo eliminarDeCola($_POST['codigo'], $_POST['pass']);
  }
?>
