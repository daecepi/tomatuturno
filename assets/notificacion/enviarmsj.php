<?php

$apiKey = 'AAAA3Vzr0UM:APA91bEmmGRLGIrcUWiiWReUGAoiy6EeKGpDSV6gU5AtrVoExmWb0UdHzYo2FLInJkGHyOURkHWYSu10zvcfPBQ1EvG7YXk6a9_5ulx8fDwPQKq61KDsR4n7gdYpu1sSiCv4t7LOKjmK-6_nMuLNgwvyuzP5nfUURg';

// Cabecera
$headers = array('Content-Type:application/json',
                 "Authorization:key=$apiKey");

// Datos
$payload = array('title' => 'Informacion de turno', 'message' => $_POST['msj'],
                 'image' => 'ttt', 'sound' => 'nokia');
$arrayId=array();
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lista=$_POST["listaid"];
    $count = count($lista);
    for ($i = 0; $i < $count; $i++) {
        array_push($arrayId, $lista[$i]);
    }
}
$data = array(
   'data' => $payload,
   'registration_ids' => $arrayId
);

// Petición
$ch = curl_init();
//definiendo encabezado
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
//URL a la que hacemos la petición
curl_setopt( $ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send" );
//verificar nombre de certificado 0= no
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
//devuelve el resultado o false si falla
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//// definimos cada uno de los parámetros
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);
curl_close($ch);
//MOSTRANDO LA RESPUESTA OBTENIDA
var_dump($response);


?>
