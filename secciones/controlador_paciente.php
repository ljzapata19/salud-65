<?php
include_once '../configuraciones/bd.php';
$medicoid =  $_GET['medicoid'] ?? '';

$conexionBD=BD::crearInstancia();
if(!empty($_POST['ingresaP'])){
    if ((empty($_POST['dni_paciente']))and (empty($_POST['fa_paciente']))and (empty($_POST['ff_paciente']))) {
        echo "<div style='color: red;'>Campo Vacío.</div>";
    } else {
        $dni_paciente = $_POST['dni_paciente'];
        $fa_paciente = $_POST['fa_paciente'];
        $ff_paciente = $_POST['ff_paciente'];
        
        $consulta= $conexionBD->prepare(
            'SELECT id FROM pacientes 
            JOIN (
                    (SELECT rela_paciente FROM medico_pacientes  
                    WHERE rela_medico = :medicoid) AS relacion)
            
            ON pacientes.id = relacion.rela_paciente WHERE dni = :dni_paciente');
           
        $consulta->execute([':dni_paciente' => $dni_paciente, ':medicoid' => $medicoid]);
        
        
        $paciente = $consulta->fetch();
        

        if ($paciente) {
            header("Location: ./medicamentos_paciente.php?medicoid=" . urlencode($medicoid) . "&pacienteid=" . urlencode($paciente['id']) . "&fa_paciente=" . urlencode($fa_paciente) . "&ff_paciente=" . urlencode($ff_paciente) );
            exit;
        } else {
            echo "<div style='color: red;'>Acceso denegado.</div>";
        }
        
    }
    
}

?>