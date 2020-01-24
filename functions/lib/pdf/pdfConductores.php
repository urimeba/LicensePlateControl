<?php
	require('fpdf.php');
	include('../../rcon2.php');
	$Con = Conectar();

	$idVehiculo = null;

	if(isset($_GET['idAux'])){
		$idVehiculo = $_GET['idAux'];
	}else{
		$idVehiculo=$_POST['idVehiculo'];
	}

	$SQL = "SELECT * FROM vehiculos WHERE idVehiculo = '$idVehiculo';";

	$Query=Ejecutarconsulta($Con,$SQL);
	$Fila =	mysqli_fetch_row($Query);

	Desconectar($Con);

	$idV=$Fila[0];
	$Propietario=$Fila[1];
	$Placa=$Fila[2];
	$Tipo=$Fila[3];
	$Uso=$Fila[4];
	$Anio=$Fila[5];
	$Color=$Fila[6];
	$Puertas=$Fila[7];
	$Modelo=$Fila[8];
	$Marca=$Fila[9];
	$Transmision=$Fila[10];
	$CapCarga=$Fila[11];
	$Serie=$Fila[12];
	$NumMotor=$Fila[13];
	$Linea=$Fila[14];
	$Sublinea=$Fila[15];
	$Cilindraje=$Fila[16];
	$Combustible=$Fila[17];
	$Origen=$Fila[18];

	$Folio = '122467847';

	//QR
	include('../qr/phpqrcode.php');

	$filename = 'qrpdf.png';

	$size=12;
	$level='Q';
	$frame=0;
	$contenido='"Propietario: "'.$Propietario.'" idV:"'.$idV.'" Placa: "'.$Placa.'" Color: "'.$Color.'" Linea: "'.$Linea; //sms:(442)200-0584 mailto:acamachos11@outook.com?subject=Hola Mundo&body=prueba skype:username?call BEGIN:VCARD."\N"

	QRcode::png($contenido, $filename, $level, $size, $frame);
	//QR

	$pdf = new FPDF();
	$pdf->AddPage('L','A4');

	$pdf->SetFont('Arial','',7);
	$pdf->Cell(40,4,'TIPO SERVICIO',0,0,'L');
	$pdf->Cell(20,4,'HOLOGRAMA',0,0,'L');
	$pdf->Cell(30,4,'FOLIO',0,0,'L');
	$pdf->Cell(30,4,'VIGENCIA',0,0,'L');
	$pdf->Cell(30,4,'PLACA',0,1,'L');

	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40,4,$Uso,0,0,'L');
	$pdf->Cell(20,4,'',0,0,'L');
	$pdf->Cell(30,4,'122467847',0,0,'L');
	$pdf->Cell(30,4,'INDEFINIDA',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(30,4,$Placa,0,1,'L');

	$pdf->SetFont('Arial','',7);
	$pdf->Cell(20,4,'Propietario',0,0,'L');

	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40,4,$Propietario,0,1,'L');
	
	$pdf->Cell(40,4,'',0,1,'L');

	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(40,4,'RFC',0,0,'L');
	$pdf->Cell(40,4,'NUMERO DE SERIE',0,0,'L');
	$pdf->Cell(40,4,'MODELO',0,1,'L');

	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40,4,$Propietario,0,0,'L');
	$pdf->Cell(40,4,$Serie,0,0,'L');
	$pdf->Cell(40,4,$Anio,0,1,'L');

	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(40,4,'LOCALIDAD',0,0,'L');
	$pdf->Cell(40,4,'MARCA/LINEA/SUBLINEA',0,0,'L');
	$pdf->Cell(40,4,'OPERACION',0,1,'L');

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,9,'QUERÉTARO',0,0,'L',);
	$pdf->Cell(40,9,$Marca." ".$Linea." ".$Sublinea,0,0,'L');
	$pdf->Cell(40,9,$Anio,0,1,'L');

	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(40,4,'MUNICIPIO',0,0,'L');
	$pdf->Cell(40,4,'',0,0,'L');
	$pdf->Cell(40,4,'FOLIO',0,1,'L');

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,4,'QUERÉTARO',0,0,'L');
	$pdf->Cell(40,4,'',0,0,'L');
	$pdf->Cell(40,4,$Folio,0,1,'L');

	$pdf->Cell(40,4,'',0,1,'L');

	// ABAJO
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(40,4,'NUMERO DE CONSTANCIA',0,0,'L');
	$pdf->Cell(15,4,'CILINDRAJE',0,0,'L');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,4,$Cilindraje,0,0,'L');
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(20,4,'CVE VEHICULAR',0,0,'L');
	$pdf->Cell(40,4,'FECHA DE EXPEDICION',0,1,'L');

	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(40,1,'DE INSCRIPCION (NCI)',0,0,'L');
	$pdf->Cell(15,1.5,'CAPACIDAD',0,0,'L');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,1.5,$CapCarga,0,0,'L');
	$pdf->Cell(20,2,'057096',0,0,'C');
	$pdf->Cell(20,3,'30-OCT-17',0,1,'L');
	$pdf->SetFont('Arial','B',6);

	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(40,1,'',0,0,'L');
	$pdf->Cell(15,1,'PUERTAS',0,0,'L');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,1,$Puertas,0,0,'L');
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,1,'CLASE',0,0,'L');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(10,1,'1',0,0,'L');
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,3,'OFICINA EXPEDIDORA 9',0,1,'L');

	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(40,1,'ORIGEN',0,0,'L');
	$pdf->Cell(15,1,'ASIENTOS',0,0,'L');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,1,'5',0,0,'L');
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,1,'TIPO',0,0,'L');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(10,1,'5',0,0,'L');
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,3,'MOVIMIENTO',0,1,'L');

	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(40,1,$Origen,0,0,'L');
	$pdf->Cell(15,1,'COMBUST.',0,0,'L');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,1,$Combustible,0,0,'L');
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,1,'USO',0,0,'L');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(10,1,'36',0,0,'L');
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(10,3,'ALTA DE PLACA',0,1,'L');

	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(40,1,'COLOR',0,0,'L');
	$pdf->Cell(15,1,'TRANSMISION',0,0,'L');
	$pdf->Cell(5,1,'',0,0,'L');
	$pdf->Cell(10,1,'RFA',0,0,'L');
	$pdf->Cell(10,1,'',0,0,'L');
	$pdf->Cell(10,3,'NUM MOTOR',0,1,'L');

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,1,$Color,0,0,'L');
	$pdf->Cell(15,1,$Transmision,0,0,'L');
	$pdf->Cell(5,1,'',0,0,'L');
	$pdf->Cell(10,1,'',0,0,'L');
	$pdf->Cell(10,1,'',0,0,'L');
	$pdf->Cell(10,3,$NumMotor,0,1,'L');
	$pdf->Cell(10,3,'',0,1,'L');

	$pdf->Cell(35,10,$pdf->Image('estadoG.png',10,90,10,10),0,0,'L');
	$pdf->Cell(10,10,$pdf->Image('estaennosotros.png',30,85,15,10),0,0,'L');
	
	$pdf->Cell(10,10,$pdf->Image('estado.png',50,85,9,10),0,0,'L');

	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(45,3,'PODER EJECUTIVO DEL ESTADO DE QUERÉTARO',0,'L');

	$pdf->SetFont('Arial','',7);
	$pdf->Cell(55,3,'',0,0,'L');
	$pdf->Cell(10,3,'SECRETARIA DE PLANEACION Y FINANZAS',0,1,'L');

	$pdf->Cell(0,0,$pdf->Image('qrpdf.png',125,85,20,20),0,1,'L');

	$pdf->Cell(40,5,'',0,1,'L',0);
	$pdf->Cell(40,5,'',0,1,'L',0);
	$pdf->Cell(30,10,'',0,0,'L',0);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(50,5,'TARJETA DE CIRCULACIÓN VEHICULAR',0,1,'L',0);

	$pdf->Output('i','te hakie.pdf');
	$temp = "../../../temp/PDF/Circulaciones/".$idVehiculo.".pdf";
	$pdf->Output('f',$temp);

	// $pdf->Image('estado.png',10,10,20,20);
	// $pdf->Output('d','te hakie.pdf');

	
	
?>