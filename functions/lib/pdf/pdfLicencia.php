<?php
	
	require('fpdf.php');
	include('../../rcon2.php');
	$Con = Conectar();
	$idLicencia = null;

	if(isset($_GET['idAux'])){
		$idLicencia = $_GET['idAux'];
	}else{
		$idLicencia = $_POST['idLicencia'];
	}

	$SQL = "SELECT * FROM Licencias WHERE idLicencia = '$idLicencia';";

	$Query=Ejecutarconsulta($Con,$SQL);
	$Fila =	mysqli_fetch_row($Query);

	Desconectar($Con);
	$idL = $Fila[0];
	$CURP = $Fila[1];
	$Exp = $Fila[2];
	$Tipo = $Fila[3];
	$Ven = $Fila[4];
	$Lugar = $Fila[5];
	$Expide = $Fila[6];
	$Foto = $Fila[7];

	$Con = Conectar();
	$SQL = "SELECT * FROM conductores WHERE CURP = '$CURP';";
	$Query = EjecutarConsulta($Con, $SQL);
	$Fila = mysqli_fetch_row($Query);
	Desconectar($Con);

	$Nombre = $Fila[1];
	$Dom = $Fila[2];
	$Donador = $Fila[4];
	$Sangre = $Fila[5];
	$Res = $Fila[6];
	$Tel = $Fila[7];
	$FechaN = $Fila[8];
	$Name = explode(' ',$Nombre);

	//QR
	include('../qr/phpqrcode.php');

	$filename = 'qrpdf.png';

	$size=12;
	$level='Q';
	$frame=0;
	$contenido='"ID Licencia: "'.$idL.'" Propietario:"'.$CURP.'" Nombre: "'.$Nombre.'" Donador: "'.$Donador.'" Tel: "'.$Tel."''"; //sms:(442)200-0584 mailto:acamachos11@outook.com?subject=Hola Mundo&body=prueba skype:username?call BEGIN:VCARD."\N"

	QRcode::png($contenido, $filename, $level, $size, $frame);
	//QR

	$pdf = new FPDF();
	$pdf->AddPage('P', 'A4');
	$pdf->SetFont('Arial', '', 5);

	$pdf->Cell(12, 12, $pdf->Image('estado.png', 12, 12, 8, 10), 'R');
	$pdf->Cell(40, 2, 'Estados Unidos Mexicanos', 0, 2);
	$pdf->Cell(40, 2, 'Poder Ejecutivo del Estado de Querétaro', 0, 2);
	$pdf->Cell(40, 1, '', 0, 2);
	$pdf->SetFont('Arial', 'B', 5);
	$pdf->Cell(40, 3, 'Secretaría de Seguridad Ciudadana', 0, 2);
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell(40, 3, 'Licencia para conducir', 0, 1);

	$pdf->SetFont('Arial', '', 4);
	$pdf->Cell(28, 16, '');
	$pdf->Cell(24, 16, '', 0, 1);//28
	$pdf->Cell(28, 3, 'No. de Licencia', 0, 2, 'R');
	$pdf->SetFont('Arial', '', 9);
	$pdf->SetTextColor(221, 83, 71);
	$pdf->Cell(28, 6, $idL, 0, 2, 'R');
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial', '', 5);
	$pdf->Cell(28, 3, 'Automovilista', 0, 2, 'R');

	$pdf->SetFont('Arial', '', 4);
	$pdf->Cell(52, 2, 'Nombre', 0, 2, 'R');
	$pdf->SetFont('Arial', '', 9);
	$pdf->Cell(52, 4, $Name[0], 0, 2, 'R');
	$pdf->Cell(52, 4, $Name[1], 0, 2, 'R');
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(52, 4, $Name[2], 0, 2, 'R');
	$pdf->SetFont('Arial', '', 4);
	$pdf->Cell(52, 2, 'Observaciones', 0, 2, 'R');

	$pdf->Cell(52, 2, 'Fecha de Nacimiento', 0, 2);
	$pdf->SetFont('Arial', '', 7);
	$pdf->Cell(52, 4, $FechaN, 0, 2);
	$pdf->SetFont('Arial', '', 4);
	$pdf->Cell(52, 2, 'Fecha de Expedición', 0, 2);
	$pdf->SetFont('Arial', '', 7);
	$pdf->Cell(52, 4, $Exp, 0, 2);
	$pdf->SetFont('Arial', '', 4);
	$pdf->Cell(26, 2, 'Valida Hasta', 0);
	$pdf->Cell(26, 2, 'Firma', 0, 1);
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell(52, 4, $Ven, 0, 2);
	$pdf->SetFont('Arial', '', 4);
	$pdf->Cell(52, 2, 'Antigüedad', 0, 2);
	$pdf->SetFont('Arial', '', 7);
	$pdf->Cell(52, 4, '0', 0, 2);

	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(248, 243, 43);
	$pdf->Cell(9, 9, $Tipo, 1, 0, 'C', TRUE);

	$pdf->SetFont('Arial', '', 5);
	$pdf->Cell(34, 3, 'AUTORIZO PARA QUE LA PRESENTE', 0, 2, 'C');
	$pdf->Cell(34, 3, 'SEA RECABADA COMO GARANTIA DE', 0, 2, 'C');
	$pdf->Cell(34, 3, 'INFRACCION', 0, 2, 'C');
	$pdf->Cell(1, 1, $pdf->Image('estado2.png',50,80,11,9), 0, 0, 'L');
	$pdf->Cell(1, 1, $pdf->Image('../../../templates/img/Firmas/'.$CURP.'.png',28,80,20,9), 0, 0, 'L');
	$pdf->Cell(1, 1, $pdf->Image('../../../templates/img/Fotos/'.$CURP.'.png',40,23,20,25), 0, 0, 'L');
	$pdf->Cell(1, 1, $pdf->Image($filename,11,49,16,16), 0, 0, 'L');

	$pdf->AddPage('P','A4');
	$pdf->SetFont('Arial','B',5);
	$pdf->Cell(12,10,$pdf->Image('911.jpg',10,10,11,9),0,0,'L');
	$pdf->Cell(27,10,$pdf->Image('CODIGO.png',22,12,27,5),0,0,'L');
	$pdf->Cell(13,10,$pdf->Image('089.png',49,10,12,9),0,1,'L');
	$pdf->Cell(52,2,'Domicilio',0,1,'R');

	$pdf->SetFont('Arial','',7);
	$pdf->MultiCell(52,4,$Dom,0,'R');

	$pdf->Cell(52,4,'',0,1,'R');

	$pdf->Cell(52,9,$pdf->Image('carritos.png',10,34,52,6),0,1,'L');

	$pdf->SetFont('Arial','B',5);
	$pdf->Cell(26,3,'Restricciones',0,0,'L');
	$pdf->Cell(26,3,'Grupo Sanguíneo',0,1,'L');

	$pdf->SetFont('Arial','',7);
	$pdf->Cell(26,5,$Res,0,0,'L');
	$pdf->Cell(26,5,$Sangre,0,1,'R');

	$pdf->SetFont('Arial','B',5);
	$pdf->Cell(52,3,'Donador de Orgános',0,1,'R');

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(52,3,$Donador,0,1,'R');
	
	$pdf->SetFont('Arial','B',5);
	$pdf->Cell(52,3,'Número de Emergencias',0,1,'R');	

	$pdf->SetFont('Arial','',7);
	$pdf->Cell(52,3,$Tel,0,1,'R');

	$pdf->Cell(52,11,$pdf->Image('firma2.png',47,63,15,11),0,1,'L');

	$pdf->SetFont('Arial','B',5);
	$pdf->Cell(52,3,'M. EN A.P. JUAN MARCOS GRANADOS TORRES',0,1,'R');
	$pdf->Cell(52,3,'SECRETARIO DE SEGURIDAD CIUDADANA',0,1,'R');

	$pdf->Cell(52,3,'Fundamento Legal',0,1,'L');

	$pdf->SetFont('Arial','',4);
	$pdf->MultiCell(52,1.5,'Articulo 19 fracción XIII Y 33 fracción II de la LeyOrganica del Poder Ejecutivo, del Estado de Querétaro, artículo 9 fracción XII Y 55 de la Ley de Tránsito del Estado de Querétaro, artículo 4 de la Ley de Procedimientos Administrativos del Estado de Querétaro, artículo 28 del Reglamento de Tránsito del Estado de Querétaro y artículo 6, fracción IV, inciso b) y 20, fracción IV de la Ley de la Secretaria de Seguridad Ciudadana del Estado De Querétaro.',0,1,'');
	
	$pdf->Cell(26,11,$pdf->Image('secretariaCiudadana.jpg',42.5,95,18,8),0,0,'');
	$pdf->Cell(26,11,$pdf->Image('estadoQ.png',15,94,12,11),0,1,'');

	$pdf->Output('i','te hakie.pdf');
	$temp = "../../../temp/PDF/Licencias/".$idL.".pdf";
	$pdf->Output('f',$temp);
?>