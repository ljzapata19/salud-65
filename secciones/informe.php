<?php
require('../librerias/fpdf186/fpdf.php');

include_once '../configuraciones/bd.php';

$conexionBD=BD::crearInstancia();
$pdf = new FPDF();
$pdf->SetFont('Arial','B',20); 
$pdf->setXY(50,15);


$medicoid = $_GET['medicoid'] ?? '';
$pacienteid = $_GET['pacienteid'] ?? '';
$fa_paciente = $_GET['fa_paciente'] ?? '';
$ff_paciente = $_GET['ff_paciente'] ?? '';

$consulta= $conexionBD->prepare('SELECT * FROM medicos WHERE id = :medicoid');
$consulta->execute([':medicoid' => $medicoid]);       
$medico = $consulta->fetch();

$consulta= $conexionBD->prepare('SELECT pacientes.*, generos.nombre AS genero FROM pacientes JOIN generos ON rela_genero = generos.id WHERE pacientes.id = :pacienteid');
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
        pacientes.id = :pacienteid 
            and medicamentos_pacientes.fecha_alta >= date(:fa_paciente)  
            and medicamentos_pacientes.fecha_alta <= date(:ff_paciente)');
$consulta->execute([':pacienteid' => $pacienteid, ':fa_paciente' => $fa_paciente, ':ff_paciente' => $ff_paciente]);  
$listaMedicamentosDelPaciente=$consulta->fetchAll();


$pdf->AddPage();
// titulo
$pdf->Cell(0, 10, 'Informe del Paciente', 0, 1, 'C');
$pdf->Ln(5); 

// info del medico 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Datos del Medico:', 1, 1,'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Matricula: ' . $medico['matricula'], 0, 1);
$pdf->Cell(0, 10, 'Nombre: ' . $medico['nombre'], 0, 1);
$pdf->Cell(0, 10, 'Apellido: ' . $medico['apellido'], 0, 1);
$pdf->Cell(0, 10, 'Especialidad: ' . $medico['especialidad'], 0, 1);

$pdf->Ln(5);

// info del paciente
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Datos del Paciente:', 1, 1,'C');
$pdf->SetFont('Arial', '', 12);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(0, 10, 'Nombre: ' . $paciente['nombre'] . ' ' . $paciente['apellido'], 0, 1);
$pdf->Cell(0, 10, 'DNI: ' . $paciente['dni'], 0, 1);
$pdf->Cell(0, 10, 'Genero: ' . $paciente['genero'], 0, 1);
$pdf->Cell(0, 10, 'Fecha de Nacimiento: ' . $paciente['fecha_nacimiento'], 0, 1);
$pdf->Cell(0, 10, 'Celular: ' . $paciente['celular'], 0, 1);

$pdf->Ln(10);

// medicamentos en una tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Lista de Medicamentos:', 1, 1, 'C');
$pdf->Cell(0, 10, 'Entre el: ' . $fa_paciente . ' y el ' . $ff_paciente, 0, 1);
$pdf->Ln(5); 
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(30, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(55, 10, 'Laboratorio', 1, 0, 'C', true);
$pdf->Cell(75, 10, 'Nombre Comercial', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Dosis', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
foreach ($listaMedicamentosDelPaciente as $medicamento) {
    $pdf->Cell(30, 10, $medicamento['id_medicamento'], 1);
    $pdf->Cell(55, 10, $medicamento['laboratorio_titular'], 1);
    $pdf->Cell(75, 10, $medicamento['nombre_comercial'], 1);
    $pdf->Cell(30, 10, $medicamento['dosis'], 1, 1);
}

$pdf->Output();

?>
