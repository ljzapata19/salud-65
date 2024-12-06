<?php include('../templates/cabecera.php'); 
        

include_once '../configuraciones/bd.php';

$conexionBD=BD::crearInstancia();

$medicoid =  $_GET['medicoid'] ?? '';
$pacienteid =  $_GET['pacienteid'] ?? '';
$fa_paciente = $_GET['fa_paciente'] ?? '';
$ff_paciente = $_GET['ff_paciente'] ?? '';

$consulta= $conexionBD->prepare('SELECT pacientes.*, generos.nombre AS genero 
                                    FROM pacientes 
                                    JOIN generos ON rela_genero = generos.id 
                                    WHERE pacientes.id = :pacienteid');
$consulta->execute([':pacienteid' => $pacienteid]);       
$paciente = $consulta->fetch();

?>
<h1 class="margtop25">Paciente: </h1>
<div style="border: 1px solid #000; padding: 10px; margin: 10px; display: grid; grid-template-columns: auto auto auto auto; gap: 10px; font-family: Arial, sans-serif;">
    
    <div><strong>Nombre:</strong></div>
    <div><?php echo $paciente['nombre']; ?></div>
    
    <div><strong>Apellido:</strong></div>
    <div><?php echo $paciente['apellido']; ?></div>
    
    <div><strong>DNI:</strong></div>
    <div><?php echo $paciente['dni']; ?></div>

    <div><strong>Genero:</strong></div>
    <div><?php echo $paciente['genero']; ?></div>
    
    <div><strong>Fecha de Nacimiento:</strong></div>
    <div><?php echo $paciente['fecha_nacimiento']; ?></div>
    
    <div><strong>Celular:</strong></div>
    <div><?php echo $paciente['celular']; ?></div>
    
    
</div>


<?php

$consulta= $conexionBD->prepare(
        'SELECT 
            *
        FROM 
            pacientes 
        JOIN 
            medicamentos_pacientes ON pacientes.id = medicamentos_pacientes.rela_paciente 
        JOIN 
            medicamentos ON medicamentos_pacientes.rela_medicamento = medicamentos.id_medicamento
        WHERE 
            pacientes.id = :pacienteid 
                and medicamentos_pacientes.fecha_alta >= date(:fa_paciente)  
                and medicamentos_pacientes.fecha_alta <= date(:ff_paciente)');

$consulta->execute([':pacienteid' => $pacienteid, ':fa_paciente' => $fa_paciente, ':ff_paciente' => $ff_paciente]);  
$listaMedicamentosDelPaciente=$consulta->fetchAll();

?>
<h1 class="margtop25">Medicamentos: </h1>
<h3>Cantidad: <?php echo $consulta->rowCount(); ?> </h3>
<p>Entre el <?php print_r($fa_paciente); ?> y el <?php print_r($ff_paciente); ?></p>
<div class="table-responsive margtop25">
    <table class="table table-primary" >
        <thead>
            <tr>
                <th scope="col">id Medicamento</th>
                <th scope="col">Laboratorio</th>
                <th scope="col">Nombre Comercial</th>
                <th scope="col">Dosis</th>
                <th scope="col">Frecuencia</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaMedicamentosDelPaciente as $medicamentoPaciente) {?>
            <tr>
                <td><?php echo $medicamentoPaciente['id_medicamento']; ?> </td>
                <td><?php echo $medicamentoPaciente['laboratorio_titular']; ?> </td>
                <td><?php echo $medicamentoPaciente['nombre_comercial']; ?> </td>
                <td><?php echo $medicamentoPaciente['dosis']; ?> </td>
                <td><?php echo $medicamentoPaciente['frecuencia']; ?> </td>


            </tr>
        <?php }?>
        </tbody>
    </table>
</div>

<a type="button"
    href="./informe.php?medicoid=<?= $medicoid ?>&pacienteid=<?= $pacienteid ?>&fa_paciente=<?= $fa_paciente?>&ff_paciente=<?= $ff_paciente ?>" 
    class="btn btn-secondary margbot25 ">
    Generar PDF
</a>
<?php include('../templates/pie.php'); ?>

