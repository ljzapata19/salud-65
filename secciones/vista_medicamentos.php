<?php include('../templates/cabecera.php'); ?>
<?php include('../secciones/medicamentos.php'); ?>
        <h1>Listado de Medicamentos</h1>

    <div
        class="table-responsive"
    >
        <table
            class="table table-primary"
        >
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Laboratorio</th>
                    <th scope="col">Nombre Comercial</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($listaMedicamentos as $medicamento) { ?>
                <tr>
                    <td><?php echo $medicamento['id_medicamento']; ?> </td>
                    <td><?php echo $medicamento['laboratorio_titular']; ?> </td>
                    <td><?php echo $medicamento['nombre_comercial']; ?> </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
    
<?php include('../templates/pie.php'); ?>