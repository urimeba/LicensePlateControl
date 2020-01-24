<?php 
	require('fpdf.php');
	include('../../rcon2.php');

	$Folio = null;

	if(isset($_GET['idAux'])){
		$Folio = $_GET['idAux'];
	}else{
		$Folio=$_POST['Folio'];
	}

	$Con = Conectar();

	$SQL = "SELECT * FROM Multas WHERE Folio = '$Folio';";

	$Query=Ejecutarconsulta($Con,$SQL);
	$Fila =	mysqli_fetch_row($Query);

	Desconectar($Con);
	$Folio = $Fila[0];
	$Licencia = $Fila[1];
	$Vehiculo = $Fila[2];
	$IdOficial = $Fila[3];
	$Monto = $Fila[4];
	$Lugar = $Fila[5];
	$Hora = $Fila[6];
	$Fecha = $Fila[7];
	$Motivo = $Fila[8];

	$Hora = explode(" ", $Hora);
	$Hora = $Hora[1];

	//BarCode
	include('../BarCode/php-barcode-master/barcode.php');
	barcode("barra.png", $Folio, 25, "horizontal", "code128", false, 1);
	//BarCode

	$pdf = new FPDF();
	$pdf->AddPage('P', [70,115]);
	$pdf->SetMargins(4,0,2);
	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Cell(14, 0,'',0, 0);
	$pdf->Cell(22.5, 8,'MULTA', 0, 0);
	$pdf->Cell(0, 0,$pdf->Image('barra.png'), 0, 1);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(20, 8, 'Folio: ', 0, 0);
	$pdf->Cell(20, 8, $Folio, 0, 1);
	$pdf->Cell(20, 8, 'Licencia: ', 0, 0);
	$pdf->Cell(20, 8, $Licencia, 0, 1);
	$pdf->Cell(20, 8, 'Vehiculo: ', 0, 0);
	$pdf->Cell(20, 8, $Vehiculo, 0, 1);
	$pdf->Cell(20, 8, 'Id Oficial: ', 0, 0);
	$pdf->Cell(20, 8, $IdOficial, 0, 1);
	$pdf->Cell(20, 8, 'Monto:', 0, 0);
	$pdf->Cell(20, 8, '$'.$Monto, 0, 1);
	$pdf->Cell(20, 4, 'Lugar: ', 0, 0);
	$pdf->MultiCell(45, 4, $Lugar, 0, 1);
	$pdf->Cell(20, 8, 'Hora: ', 0, 0);
	$pdf->Cell(20, 8, $Hora, 0, 1);
	$pdf->Cell(20, 8, 'Fecha: ', 0, 0);
	$pdf->Cell(20, 8, $Fecha, 0, 1);
	$pdf->Cell(20, 8, 'Motivo: ', 0, 0);
	$pdf->Cell(20, 8, $Motivo, 0, 1);

	$pdf->Output('i','te hakie.pdf');
	$temp = "../../../temp/PDF/Multas/".$Folio.".pdf";
	$pdf->Output('f',$temp);
?>