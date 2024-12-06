<?php

include_once '../configuraciones/bd.php';
$conexionBD=BD::crearInstancia();


$consulta= $conexionBD->prepare('SELECT * FROM medicamentos');
$consulta->execute();
$listaMedicamentos=$consulta->fetchAll();



?>