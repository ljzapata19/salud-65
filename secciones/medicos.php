<?php

include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();


$consulta= $conexionBD->prepare('SELECT * FROM medicos');
$consulta->execute();
$listaMedicos=$consulta->fetchAll();



?>