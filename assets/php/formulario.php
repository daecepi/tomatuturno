<?php
include_once 'bibliotecaPHP.php';


$carr = $_POST['phone'][0].$_POST['phone'][1].$_POST['phone'][2];

//$output = json_encode(array('type'=>'success', 'text' => 'Hi , thank you for your email, we will get back to you shortly.'));
//die($output);
echo agregaColaEstudiante($_POST['phone'],$_POST['name'],$carr,$_POST['pass']);
?>
