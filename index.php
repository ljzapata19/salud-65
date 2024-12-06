<!doctype html>
<html lang="en">
    <head>
        <title>SISTEMA +65</title>
        <link rel="stylesheet" href="./templates/style.css">
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <nav class="navbar navbar-expand navbar-light" style="background-color: #343a40;">
            <div class="nav navbar-nav">
                <a class="nav-item nav-link active cambia" aria-current="page" href="index.php" style="color: white;">Inicio</a>
                <a class="nav-item nav-link cambia" href="./secciones/vista_medicos.php" style="color: white;">Médicos</a>
                <a class="nav-item nav-link cambia" href="./secciones/vista_pacientes.php" style="color: white;">Pacientes</a>
                <a class="nav-item nav-link cambia" href="./secciones/vista_medicamentos.php" style="color: white;">Medicamentos</a>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <form method="post">
                        <div class="card margtop25">
                            <div class="card-header">Seleccionar Médico</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">Medico</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="dni_medico"
                                        id="dni_medico"
                                        aria-describedby="helpId"
                                        placeholder="DNI"
                                    />
                                    <small id="helpId" class="form-text text-muted">Escriba DNI del medico.</small>
                                </div>
                                
                                <?php include_once './configuraciones/bd.php';?>
                                <?php include_once './controlador_medico.php';?>
                                <input type="submit" name="ingresa" class="btn btn-secondary" value="Seleccionar">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
            <?php
                include_once './configuraciones/bd.php';
                $conexionBD=BD::crearInstancia();

                $consulta= $conexionBD->prepare('SELECT * FROM medicos');
                $consulta->execute();
                $listaMedicos=$consulta->fetchAll();

            ?>
            <h1>Listado de Médicos</h1>

            <div class="table-responsive"  >
                <table class="table table-primary" >
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
        </div>
       
        
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
        <footer class="text-center">
            <div class="pt-1 ">
                <p> - 2024 -</p>
            </div>
        </footer>
    </body>
</html>
