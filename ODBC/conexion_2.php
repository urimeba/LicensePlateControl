<?php 
	$dsn="prueba";
	$usuario="";
	$password="";

	$conexion = odbc_connect($dsn, $usuario, $password);

	$SQL = "SELECT * FROM alumnos;";
	$Consulta = odbc_exec($conexion, $SQL);

	$resultado = odbc_result_all($consulta, "border = 1");
	print($resultado);

	odbc_close($conexion);
?>