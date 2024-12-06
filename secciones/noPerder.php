<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
    
        <div class="container">
            
            <div class="row">
                <div class="col-md-4">
                
                </div>
                <div class="col-md-4">
                    <br>
                    <form method="post">
                        <div class="card">
                            
                            <div class="card-header">
                                Inicio de Sesión
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">Médico</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="dni_medico"
                                        id="dni_medico"
                                        aria-describedby="helpId"
                                        placeholder="DNI"
                                    />
                                    <small id="helpId" class="form-text text-muted">Escriba su documento</small>
                                </div>
                                <?php include_once './configuraciones/bd.php';?>
                                <?php include_once './controlador_medico.php';?>
                                <br>
                                <input type="submit" name="ingresa" value="Iniciar">
                                
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                
                </div>
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
    </body>
</html>





# controlador

<?php
include_once './configuraciones/bd.php';

$conexionBD=BD::crearInstancia();
if(!empty($_POST['ingresa'])){
    if (empty($_POST['dni_medico'])) {
        echo "<div style='color: red;'>Campo Vacío.</div>";
    } else {
        $dni_medico = $_POST['dni_medico'];

        $consulta= $conexionBD->prepare('SELECT id FROM medicos WHERE dni = :dni_medico');
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








#pdf

<?php
require('../librerias/fpdf186/fpdf.php');

include_once '../configuraciones/bd.php';

$conexionBD=BD::crearInstancia();
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16); 

$medicoid = $_GET['medicoid'] ?? '';
$pacienteid = $_GET['pacienteid'] ?? '';

$consulta= $conexionBD->prepare('SELECT * FROM medicos WHERE id = :medicoid');
$consulta->execute([':medicoid' => $medicoid]);       
$medico = $consulta->fetch();


$consulta= $conexionBD->prepare('SELECT * FROM pacientes WHERE id = :pacienteid');
$consulta->execute([':pacienteid' => $pacienteid]);       
$paciente = $consulta->fetch();




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
        pacientes.id = :pacienteid; ');

$consulta->execute([':pacienteid' => $pacienteid]);  
$listaMedicamentosDelPaciente=$consulta->fetchAll();

// Título del informe
$pdf->Cell(0, 10, 'Informe del Paciente', 0, 1, 'C');
$pdf->Ln(5); // Espacio extra

// Información del médico en un recuadro
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Medico:', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetFillColor(230, 230, 230); // Color de fondo
$pdf->Cell(190, 40, '', 1, 1, 'L', true); // Recuadro
$pdf->SetY($pdf->GetY() - 35); // Ajustar posición para escribir dentro del recuadro
$pdf->SetX(10);
$pdf->Cell(0, 10, 'ID: ' . $medico['id'], 0, 1);
$pdf->SetX(10);
$pdf->Cell(0, 10, 'Nombre: ' . $medico['nombre'] . ' ' . $medico['apellido'], 0, 1);

// Espacio antes del siguiente recuadro
$pdf->Ln(5);

// Información del paciente en un recuadro
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Paciente:', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(190, 60, '', 1, 1, 'L', true); // Recuadro
$pdf->SetY($pdf->GetY() - 55);
$pdf->SetX(10);
$pdf->Cell(0, 10, 'ID: ' . $paciente['id'], 0, 1);
$pdf->SetX(10);
$pdf->Cell(0, 10, 'Nombre: ' . $paciente['nombre'] . ' ' . $paciente['apellido'], 0, 1);
$pdf->SetX(10);
$pdf->Cell(0, 10, 'DNI: ' . $paciente['dni'], 0, 1);
$pdf->SetX(10);
$pdf->Cell(0, 10, 'Fecha de Nacimiento: ' . $paciente['fecha_nacimiento'], 0, 1);

// Espacio antes de la tabla
$pdf->Ln(10);

// Medicamentos en una tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Medicamentos:', 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(30, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Laboratorio', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Nombre Comercial', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Dosis', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Frecuencia', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
foreach ($listaMedicamentosDelPaciente as $medicamento) {
    $pdf->Cell(30, 10, $medicamento['id_medicamento'], 1);
    $pdf->Cell(50, 10, $medicamento['laboratorio_titular'], 1);
    $pdf->Cell(50, 10, $medicamento['nombre_comercial'], 1);
    $pdf->Cell(30, 10, $medicamento['dosis'], 1);
    $pdf->Cell(30, 10, $medicamento['frecuencia'], 1, 1);
}

// Salida del PDF
$pdf->Output();

?>
