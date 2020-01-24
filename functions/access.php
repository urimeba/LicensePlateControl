<?php

session_start();

$user = $_POST['username'];
$psw = $_POST['psw'];
$key = $_FILES['key'];

$ubicacionK = $key['tmp_name'];

include('conexion.php');
$Con = Conectar();
$SQL = "Select * FROM usuarios WHERE Username = '$user';";
$Query = EjecutarConsulta($Con, $SQL);

$n = mysqli_num_rows($Query);
if($n == 0){
	//No encuentra usuario
	header("Location:../index.php?view=".urlencode("login"));
}else{
	$fila = mysqli_fetch_row($Query);
	if($fila[2] == 1){
		if($fila[1] == $psw){
			if($ubicacionK != null){
				$string="";
				$data = fopen($ubicacionK,"r");
				while(!feof($data)){
					$s1 = fgets($data);
					$string = $string.$s1;
				}
				if ($fila[4]==$string) {
					//Entra correctamente
					$SQL = "UPDATE usuarios SET Intento = 0 WHERE Username = '$user'";
					EjecutarConsulta($Con, $SQL);
					$_SESSION['username'] = $user;
					$_SESSION['val'] = TRUE;
					$_SESSION['time'] = time();
					header("Location:../index.php?view=".urlencode("menu"));
				}else{
					header("Location:../index.php?view=".urlencode("login"));
				}
				fclose($data);
			}else{
				header("Location:../index.php?view=".urlencode("login"));
			}
		}else{
			//Contrasena incorrecta
			$i = $fila[3]+1;
			if($fila[3] > 2){
				//Bloqueado
				$SQL = "UPDATE usuarios SET Estado = 0, Intento = 0 WHERE Username = '$user'";
				EjecutarConsulta($Con, $SQL);
				header("Location:../index.php?view=".urlencode("block"));
			}else{
				//Contador de intentos
				$SQL = "UPDATE usuarios SET Intento='$i' WHERE Username = '$user'";
				EjecutarConsulta($Con, $SQL);
			}
			header("Location:../index.php?view=".urlencode("login"));
		}
	}else{
		//Usuario no existe
		header("Location:../index.php?view=".urlencode("login"));
	}
}
Desconectar($Con);

?>