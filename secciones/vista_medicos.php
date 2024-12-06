<?php include('../templates/cabecera.php'); ?>
<?php include('../secciones/medicos.php'); ?>
        <h1>Listado de Médicos</h1>

    <div
        class="table-responsive"
    >
        <table
            class="table table-primary"
        >
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Matricula</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Especialidad</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Domicilio</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php foreach($listaMedicos as $medico) {?>
                <tr>
                    <td><?php echo $medico['id']; ?> </td>
                    <td><?php echo $medico['matricula']; ?> </td>
                    <td><?php echo $medico['dni']; ?> </td>
                    <td><?php echo $medico['nombre']; ?> </td>
                    <td><?php echo $medico['apellido']; ?> </td>
                    <td><?php echo $medico['especialidad']; ?> </td>
                    <td><?php echo $medico['telefono']; ?> </td>
                    <td><?php echo $medico['domicilio']; ?> </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
    
<?php include('../templates/pie.php'); ?>