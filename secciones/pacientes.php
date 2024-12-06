<?php

include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();


$consulta= $conexionBD->prepare('SELECT * FROM pacientes');
$consulta->execute();
$listaPacientes=$consulta->fetchAll();



?>