<?php
include_once './configuraciones/bd.php';

$conexionBD=BD::crearInstancia();

if(!empty($_POST['ingresa'])){
    if (empty($_POST['dni_medico'])  ){
        echo "<div style='color: red;'>Campo Vacío.</div>";
    } else {
        $dni_medico = $_POST['dni_medico'];

        $consulta= $conexionBD->prepare('SELECT * FROM medicos WHERE dni = :dni_medico');
        $consulta->execute([':dni_medico' => $dni_medico]);

        $medico = $consulta->fetch();

        if ($medico) {
            header("Location: ./secciones/inicio.php?medicoid=" . urlencode($medico['id']));
            exit;
        } else {
            echo "<div style='color: red;'>Acceso denegado.</div>";
        }

    }
    
}

?>