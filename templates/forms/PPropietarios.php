<?php 

include('functions/rcon.php');
if(isset($_POST['Submit'])){
	$RFC= $_POST['RFC'];
	$CURP= $_POST['CURP'];
	$Nombre= $_POST['nombre'];
	$Direccion= $_POST['direccion'];

	$Con = Conectar();
	$SQL = "INSERT INTO propietarios VALUES('$RFC','$CURP','$Nombre','$Direccion');";
	EjecutarConsulta($Con, $SQL);

	$affected = mysqli_affected_rows($Con);
	if($affected > 0){
		$msg = "Se registró la información del nuevo propietario correctamente";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}elseif($affected == 0){
		$msg = "Se presentó un error con la consulta";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}else{
		$msg = "No fue posible registrar el propietario, verifique que la CURP no este ya ocupada";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	Desconectar($Con);
}

?>