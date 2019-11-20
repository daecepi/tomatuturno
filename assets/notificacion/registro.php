<?php
    require_once "lib/nusoap.php";
   $params;
      $wsdl="http://localhost/ejemplows/serverUser.php?wsdl";
      $serviciosUser = new nusoap_client($wsdl,true);
if (isset($_POST['id'])) {
  $id_rec=$_POST['id'];
$params= array('id_usuario' => $id_rec);
$result = $serviciosUser->call("registrarId", $params);

    $error = $serviciosUser->getError();
    if ($error) {
        echo json_encode(array('res' => 'no' ));
    }
    if($result=="1"){
      echo json_encode(array('res' => 'si' ));
    }
    else{
        echo json_encode(array('res' => 'no' ));
    }
}
else{
  $result = $serviciosUser->call("getIds",array());
    $error = $serviciosUser->getError();
    if ($error) {
        echo json_encode(array('res' => 'nosssss', 'err:'=> $error));
    }
    else{
        echo json_encode($result);
    }
}
 
?>