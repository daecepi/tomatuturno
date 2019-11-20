<?php
  include_once 'bibliotecaPHP.php';

  $turnosPorPrograma = arrayTurnosCola();
  $turnosPorCarreraEncola = listaColaPorCarrera();
  $turnos = arrayColaEstudiantes();

  $arregloGeneral = array(
						"estados" => $turnosPorPrograma,
						"turnos" => $turnosPorCarreraEncola,
            "personas" => $turnos
						);
  $variable = json_encode($arregloGeneral, true);
  echo ($variable);
?>
