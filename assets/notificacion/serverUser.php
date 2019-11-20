<?php
    require_once 'lib/nusoap.php';
        $servicio = new soap_server();

      $namesp="urn:servicioRegistro";

   $servicio->configureWSDL("servicioRegistroId",$namesp);
  $servicio->schemaTargetNamespace=$namesp;

$servicio->wsdl->addComplexType(
        'identificadores',
        'complexType',
        'struct',
'all',
'',
array(
'id'=>array('name'=>'id','type'=>'xsd:Array')//'name'=>'id'  , 'type'=>'xsd:string',
)
);
      
    $servicio->register("registrarId",
        array("id_usuario" => "xsd:string"),
        array("return" => "xsd:string"),$namesp);
       $servicio->register("getIds",
        array(),
        array("return" => "tns:identificadores"),$namesp);//  tns:identificadores

    function registrarId($id_usuario) {
        $num=5;
        $bd=new mysqli('localhost','root','','testear');
    $sentencia="INSERT INTO usuarios(user_idreg,user_fecha) values ('$id_usuario','".date("Y-m-d H:i:s")."')";
        $resultado=$bd->query($sentencia);
        if($bd->affected_rows>0){
             $num=1;
            $bd->close();
        }
        else{
             $num=0;
            $bd->close();
            }

           return "".$num;

    }

    function getIds(){
      $bd=new mysqli('localhost','root','','testear');
       $resultado=$bd->query("SELECT user_idreg AS id FROM usuarios");

       //$ids=array();
        $ids=array();
       if ($resultado) {
        while($data = $resultado->fetch_assoc()) {
          array_push($ids, $data);
        }
          $resultado->close();
          return array("id" => $ids);
      }
    }

$HTTP_RAW_POST_DATA=isset( $HTTP_RAW_POST_DATA)? $HTTP_RAW_POST_DATA :'';
$servicio->service($HTTP_RAW_POST_DATA);
?>