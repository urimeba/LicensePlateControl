<?php 
$dsn = "ODBC_Ejemplo";
$user = "root";
$pass = "";
$nombre = $_POST['nombre'];

$id = odbc_connect($dsn, $user, $pass);

if($id == false){
	die('No hubo conexión :C');
}else{
	echo "Si hay conexión :D";
	echo "<br>";
	echo "Consulta:<br>";

	$SQL="SELECT * FROM usuarios WHERE Username Like '%{$nombre}%'";
	if(($result = odbc_exec($id,$SQL))==false){
		die("Error en la búsqueda: ".odbc_errormsg($id));
	}else{
		//odbc_result_all($result);
		//print_r($row);
		while($row = odbc_fetch_array($result)){
			echo "Nombre: ".$row['Username']."<br>";
			echo "Contraseña: ".$row['Psw']."<br>";
			echo "Estado: ".$row['Estado']."<br>";
			echo "Intentos: ".$row['Intento']."<br>";
		}
	}
}
//odbc_free_result($result);
odbc_close($id);



?>