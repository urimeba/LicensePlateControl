<?php

include('functions/rcon.php');
if(isset($_POST['Submit'])){
	$Vehiculo = $_POST['vehiculo'];
	$Fecha = date('Y-m-d');
	$Periodo = $_POST['periodo'];
	$Dictamen = $_POST['dictamen'];

	$Con = Conectar();
	$SQL = "INSERT INTO verificaciones(Vehiculo, Fecha, Periodo, Dictamen) VALUES ('$Vehiculo','$Fecha','$Periodo','$Dictamen');";
	EjecutarConsulta($Con,$SQL);

	$affected = mysqli_affected_rows($Con);
	if($affected > 0){
		$msg = "Verificación registrada correctamente";
		if ($Dictamen == "1") {
			$Dictamen= "Aprobado";
		}else{
			$Dictamen= "Reprobado";
		}
	
		if(!$verificaciones = new SimpleXMLElement('temp/XML/Verificaciones.xml', null, true)){
		}else{
			$nuevo = $verificaciones->addChild('verificacion');
			$nuevo->addChild('Vehiculo',$Vehiculo);
			$nuevo->addChild('Fecha',$Fecha);
			$nuevo->addChild('Periodo',$Periodo);
			$nuevo->addChild('Dictamen',$Dictamen);
			$verificaciones->asXML('temp/XML/Verificaciones.xml');
		}
		echo "<script type='text/javascript'>alert('$msg');</script>";
		$SQL = "SELECT MAX(Folio) from verificaciones";
        $id = mysqli_fetch_row(EjecutarConsulta($Con, $SQL));
        header('Location: functions/lib/pdf/pdfVerificaciones.php?idAux='.urlencode($id[0]));
	}elseif($affected == 0){
		$msg = "Verifique que el vehiculo exista";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}else{
		$msg = "Verifique que el vehiculo exista";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	Desconectar($Con);
}

?>