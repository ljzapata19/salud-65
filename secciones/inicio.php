<?php include('../templates/cabecera.php'); 
        

include_once '../configuraciones/bd.php';

$conexionBD=BD::crearInstancia();

$medicoid =  $_GET['medicoid'] ?? '';

$consulta= $conexionBD->prepare('SELECT * FROM medicos WHERE id = :medicoid');
$consulta->execute([':medicoid' => $medicoid]);       
$medico = $consulta->fetch();

?>
<h1 class="margtop25"> Médico: </h1>
<div style="border: 1px solid #000; padding: 10px; margin: 10px; display: grid; grid-template-columns: auto auto auto auto; gap: 10px; font-family: Arial, sans-serif;">
    <div><strong>ID:</strong></div>
    <div><?php echo $medico['id']; ?></div>
    <div><strong>Matrícula:</strong></div>
    <div><?php echo $medico['matricula']; ?></div>

    <div><strong>DNI:</strong></div>
    <div><?php echo $medico['dni']; ?></div>
    <div><strong>Nombre:</strong></div>
    <div><?php echo $medico['nombre']; ?></div>

    <div><strong>Apellido:</strong></div>
    <div><?php echo $medico['apellido']; ?></div>
    <div><strong>Especialidad:</strong></div>
    <div><?php echo $medico['especialidad']; ?></div>

    <div><strong>Teléfono:</strong></div>
    <div><?php echo $medico['telefono']; ?></div>
    <div><strong>Domicilio:</strong></div>
    <div><?php echo $medico['domicilio']; ?></div>
</div>
<form method="post">
        <div class="card margtop25">
            <div class="card-header"> Selecciona Paciente  </div>
            <div class="card-body">
                <div class="mb-3">
                        <label for="" class="form-label">Paciente</label>
                        <input
                        type="text"
                        class="form-control"
                        name="dni_paciente"
                        id="dni_paciente"
                        aria-describedby="helpId"
                        placeholder="DNI"
                        required
                        />
                </div>
                <div class="mb-3">
                        <label for="" class="form-label">Ingrese fecha inicio</label>
                        <input
                        type="date"
                        class="form-control"
                        name="fa_paciente"
                        id="fa_paciente"
                        aria-describedby="helpId"
                        placeholder="fecha alta"
                        required/>
                </div>
                <div class="mb-3">
                        <label for="" class="form-label">Ingrese fecha fin</label>
                        <input
                        type="date"
                        class="form-control"
                        name="ff_paciente"
                        id="ff_paciente"
                        aria-describedby="helpId"
                        placeholder="fecha fin"
                        required/>
                </div>
                <?php include_once '../configuraciones/bd.php';?>
                <?php include_once './controlador_paciente.php';?>
                <input type="submit" name="ingresaP" class="btn btn-secondary" value="Buscar">
            </div>   
        </div>
</form>
<?php

$consulta= $conexionBD->prepare(
        'SELECT * FROM pacientes 
        JOIN (
                (SELECT rela_paciente FROM medico_pacientes  
                WHERE rela_medico = :medicoid) AS relacion)
        
        ON pacientes.id = relacion.rela_paciente');

$consulta->execute([':medicoid' => $medicoid]);
$listaPacientesDelMedico=$consulta->fetchAll();

?>
<div class="table-responsive margtop25 margbot25">
    <h1> Lista de Pacientes:</h1>
    <table class="table table-primary margtop25" >
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">DNI</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Fecha de Nacimiento</th>
                <th scope="col">Celular</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaPacientesDelMedico as $paciente) {?>
                <tr>
                    <td><?php echo $paciente['id']; ?> </td>
                    <td><?php echo $paciente['dni']; ?> </td>
                    <td><?php echo $paciente['nombre']; ?> </td>
                    <td><?php echo $paciente['apellido']; ?> </td>
                    <td><?php echo $paciente['fecha_nacimiento']; ?> </td>
                    <td><?php echo $paciente['celular']; ?> </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>
<?php include('../templates/pie.php'); ?>

