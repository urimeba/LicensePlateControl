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

	$SQL = "SELECT * FROM Verificaciones WHERE Folio = '$Folio';";

	$Query=Ejecutarconsulta($Con,$SQL);
	$Fila =	mysqli_fetch_row($Query);

	$Folio = $Fila[0];
	$idVehiculo = $Fila[1];
	$Fecha = $Fila[2];
	$Periodo = $Fila[3];
	$Dictamen = $Fila[4];

	if ($Dictamen=="1") {
		$Dictamen = "APROBADO";
	}else{
		$Dictamen = "RECHAZADO";
	}

	$SQL = "SELECT * FROM Vehiculos WHERE IdVehiculo = '$idVehiculo';";

	$Query=Ejecutarconsulta($Con,$SQL);
	$Fila =	mysqli_fetch_row($Query);

	$Propietario = $Fila[1];
	$Placa = $Fila[2];
	$Tipo = $Fila[3];
	$Uso = $Fila[4];
	$Anio = $Fila[5];
	$Color = $Fila[6];
	$Puertas = $Fila[7];
	$Modelo = $Fila[8];
	$Marca = $Fila[9];
	$Transmision = $Fila[10];
	$CapCarga = $Fila[11];
	$Serie = $Fila[12];
	$NumMotor = $Fila[13];
	$Linea = $Fila[14];
	$Sublinea = $Fila[15];
	$Cilindraje = $Fila[16];
	$Combustible = $Fila[17];
	$Origen = $Fila[18];

	Desconectar($Con);
	// BarCode
	include('../BarCode/php-barcode-master/barcode.php');
	barcode("barra.png", $Propietario, 25, "horizontal", "code128", true, 1);
	// BarCode

	//QR
	include('../qr/phpqrcode.php');

	$filename = 'qrpdfV.png';

	$size=4;
	$level='Q';
	$frame=0;
	$contenido='"ID Vehiculo: "'.$idVehiculo.'" Propietario:"'.$Propietario.'" Placa: "'.$Placa.'" Periodo: "'.$Periodo.'" Fecha: "'.$Fecha." Dictamen: ".$Dictamen."''"; //sms:(442)200-0584 mailto:acamachos11@outook.com?subject=Hola Mundo&body=prueba skype:username?call BEGIN:VCARD."\N"

	QRcode::png($contenido, $filename, $level, $size, $frame);
	$QR = 'qrpdfV.png';
	//QR

	$pdf = new FPDF();
	$pdf->AddPage('L', [155,350]);
	$pdf->SetMargins(4,0,0);
	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Image($QR,280,40);
	$pdf->Cell(70, 15,$pdf->Image('secretariaDS.png',0,0), 0, 0);
	$pdf->Cell(50, 15,$pdf->Image('VVQ.png',80,5), 0, 0);
	
	// $pdf->Cell(14, 14,'',1, 0);
	$pdf->SetFillColor(235,147,146);
	$pdf->Cell(145, 8,'PROGRAMA ESTATAL DE VERIFICACIÓN VEHICULAR', 0,2,'R',true);
	$pdf->Cell(145, 8,'GOBIERNO DEL ESTADO DE QUERÉTARO', 0, 2,'R',true);
	$pdf->Cell(50, 15,$pdf->Image('barra.png',280,12.5), 0, 1);
	$pdf->SetFont('Arial', '', 8);
	$pdf->SetTextColor(149,149,141);
	$pdf->Cell(50, 8,'DATOS DEL VEHÍCULO', 0, 1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Cell(5, 8,'', 0, 0);
	$pdf->Cell(60, 6,$Uso, 0, 0);
	$pdf->Cell(50, 6,$Marca, 0, 0);
	$pdf->Cell(50, 6,$Linea, 0, 0);
	$pdf->Cell(50, 6,$Anio, 0, 0);
	$pdf->Cell(50, 6,$Placa, 0, 1);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->SetDrawColor(149,149,141);
	$pdf->SetTextColor(149,149,141);
	$pdf->Cell(65, 8,'TIPO DE SERVICIO', 'T', 0);
	$pdf->Cell(50, 8,'MARCA', 'T', 0);
	$pdf->Cell(50, 8,'SUB MARCA', 'T', 0);
	$pdf->Cell(50, 8,'AÑO/MODELO', 'T', 0);
	$pdf->Cell(50, 8,'PLACAS', 'T', 1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Cell(5, 8,'', 0, 0);
	$pdf->Cell(65, 8,$Serie, 0, 0);
	$pdf->Cell(45, 8,'---', 0, 0);
	$pdf->Cell(70, 8,$Combustible, 0, 0);
	$pdf->Cell(50, 8,$NumMotor, 0, 1);
	$pdf->SetDrawColor(149,149,141);
	$pdf->SetTextColor(149,149,141);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(65, 8,'NÚMERO DE SERIE', 'T', 0);
	$pdf->Cell(50, 8,'CLASE', 'T', 0);
	$pdf->Cell(50, 8,'TIPO DE COMBUSTIBLE', 'T', 0);
	$pdf->Cell(100, 8,'No. IDENTIFICACIÓN VEHICULAR (NIV)', 'T', 1);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Cell(5, 8,'', 0, 0);
	$pdf->Cell(60, 6,$Cilindraje, 0, 0);
	$pdf->Cell(50, 6,$Tipo, 0, 0);
	$pdf->Cell(50, 6,$Origen, 0, 0);
	$pdf->Cell(50, 6,'SANTIAGO DE QUERETARO', 0, 1);
	$pdf->SetDrawColor(149,149,141);
	$pdf->SetTextColor(149,149,141);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(65, 8,'NUMERO DE CILINDROS', 'T', 0);
	$pdf->Cell(50, 8,'TIPO DE CARROCERIA', 'T', 0);
	$pdf->Cell(50, 8,'ORIGEN', 'T', 0);
	$pdf->Cell(100, 8,'LUGAR DONDE SE REALIZA', 'T', 1);
	$pdf->Cell(265, 8,'', '', 1);
	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Cell(60, 6,"FECHA: ", 0, 0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50, 6,$Fecha, 0, 1);
	$pdf->SetTextColor(149,149,141);
	$pdf->Cell(60, 6,"PERIODO: ", 0, 0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50, 8,$Periodo, 0, 1);
	$pdf->Cell(145, 10,"DICTAMEN: ", 0, 0);
	$pdf->SetFont('Arial', 'B', 35);
	if ($Dictamen == "APROBADO") {
		$pdf->SetTextColor(60,250,70);
	}else{
		$pdf->SetTextColor(255,0,0);
	}
	$pdf->Cell(70, 8,$Dictamen, 0, 1);

	

	
	// $pdf->SetFont('Arial', 'B', 8);
	// $pdf->Cell(20, 8, 'Folio: ', 0, 0);
	// $pdf->Cell(20, 8, $Folio, 0, 1);
	// $pdf->Cell(20, 8, 'Licencia: ', 0, 0);
	// $pdf->Cell(20, 8, $Licencia, 0, 1);
	// $pdf->Cell(20, 8, 'Vehiculo: ', 0, 0);
	// $pdf->Cell(20, 8, $Vehiculo, 0, 1);
	// $pdf->Cell(20, 8, 'Id Oficial: ', 0, 0);
	// $pdf->Cell(20, 8, $IdOficial, 0, 1);
	// $pdf->Cell(20, 8, 'Monto:', 0, 0);
	// $pdf->Cell(20, 8, '$'.$Monto, 0, 1);
	// $pdf->Cell(20, 4, 'Lugar: ', 0, 0);
	// $pdf->MultiCell(45, 4, $Lugar, 0, 1);
	// $pdf->Cell(20, 8, 'Hora: ', 0, 0);
	// $pdf->Cell(20, 8, $Hora, 0, 1);
	// $pdf->Cell(20, 8, 'Fecha: ', 0, 0);
	// $pdf->Cell(20, 8, $Fecha, 0, 1);
	// $pdf->Cell(20, 8, 'Motivo: ', 0, 0);
	// $pdf->Cell(20, 8, $Motivo, 0, 1);

	$pdf->Output('i','te hakie.pdf');
	$temp = "../../../temp/PDF/Verificaciones/".$Folio.".pdf";
	$pdf->Output('f',$temp);
?>