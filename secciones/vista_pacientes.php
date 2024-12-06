<?php include('../templates/cabecera.php'); ?>
<?php include('../secciones/pacientes.php'); ?>
        <h1>Listado de Pacientes</h1>

    <div
        class="table-responsive"
    >
        <table
            class="table table-primary"
        >
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
            <?php foreach($listaPacientes as $paciente) {?>
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