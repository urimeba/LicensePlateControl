<?php

include('functions/rcon.php');
if(isset($_POST['Submit'])){
	$CURP= $_POST['CURP'];
	$Nombre= $_POST['nombre'];
	$Domicilio= $_POST['domicilio'];	
	$archivo=$_FILES['archivo'];

	$archivo['name']=$CURP . ".png";
    $name = $archivo['name'];
    $location = "C:/xampp/htdocs/ControlVehicular/templates/img/Firmas/";
    $tmp_name = $archivo['tmp_name'];
	
	copy($tmp_name, $location.$name);
	move_uploaded_file($tmp_name, $location.$name);
    $location2=$location.$name;

	$Donante = $_POST['donante'];
	$GrupoS= $_POST['grupo'];
	$Restricciones= $_POST['restricciones'];
	$TelE= $_POST['tel'];
	$FechaN= $_POST['fecha'];

    $Con = Conectar();
	$SQL = "INSERT INTO conductores VALUES ('$CURP', '$Nombre', '$Domicilio', '$location2', '$Donante','$GrupoS', '$Restricciones', '$TelE', '$FechaN');";
	EjecutarConsulta($Con,$SQL);

	$affected = mysqli_affected_rows($Con);
	if($affected > 0){
		$msg = "Se registró la información del nuevo conductor correctamente";
		//XML
		if(!$conductores = new SimpleXMLElement('temp/XML/Conductores.xml', null, true)){
		}else{
			$nuevo = $conductores->addChild('conductor');
			$nuevo->addChild('CURP',$CURP);
			$nuevo->addChild('nombre',$Nombre);
			$nuevo->addChild('domicilio',$Domicilio);
			$nuevo->addChild('firma',$location2);
			$nuevo->addChild('donador',$Donante);
			$nuevo->addChild('gpoSanguineo',$GrupoS);
			$nuevo->addChild('restriccion',$Restricciones);
			$nuevo->addChild('telEmergencia',$TelE);
			$nuevo->addChild('fechaNacimiento',$FechaN);
		
			$conductores->asXML('temp/XML/Conductores.xml');
		}
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}elseif($affected == 0){
		$msg = "No fue posible registrar el conductor";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}else{
		$msg = "No fue posible registrar el conductor";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	Desconectar($Con);
}

?>