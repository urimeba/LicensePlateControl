<?php

include('functions/rcon.php');
if(isset($_POST['Submit'])){
	$Propietario = $_POST['propietario'];
	$Placa = $_POST['placa'];
	$Tipo = $_POST['tipo'];
	$Modelo = $_POST['modelo'];
	$Anio = $_POST['anio'];
	$Uso = $_POST['uso'];
	$Color = $_POST['color'];
	$numPuertas = $_POST['numPuertas'];
	$Marca = $_POST['marca'];
	$Transmision = $_POST['transmision'];
	$capCarga = $_POST['capCarga'];
	$Serie = $_POST['serie'];
	$numMotor = $_POST['numMotor'];
	$Linea = $_POST['linea'];
	$Sublinea = $_POST['sublinea'];
	$Cilindraje = $_POST['cilindraje'];
	$Combustible = $_POST['combustible'];
	$Origen = $_POST['origen'];

	$Con = Conectar();
	$SQL = "INSERT INTO vehiculos(Propietario, Placa, Tipo, Modelo, Anio, Uso, Color, Puertas, Marca, Transmision, CapCarga, Serie, NumMotor, Linea, Sublinea, Cilindraje, Combustible, Origen) 
	VALUES ('$Propietario','$Placa','$Tipo','$Modelo','$Anio','$Uso','$Color','$numPuertas','$Marca','$Transmision','$capCarga','$Serie','$numMotor','$Linea','$Sublinea','$Cilindraje','$Combustible','$Origen');";
	EjecutarConsulta($Con, $SQL);

	$affected = mysqli_affected_rows($Con);
	if($affected > 0){
		$msg = "Se registró la información del nuevo vehículo correctamente";
		//ODBC
		// 696969
		// funcion para obtener todos los datos a almacenar de una tabla en arreglo assoc
		function obtener_todo($consulta) {
			$i = 0;
			$filas = array();
			while ($fila = mysqli_fetch_assoc($consulta)) { 
				foreach ($fila AS $key => $value) {
					$filas[$i][$key] = $fila[$key];
				}
				$i++;
			}
			return $filas;
		}

		// funcion para obtener total filas, odbc_num_rows no sirve (da -1)
		function odbc_total_filas($query) {
			$numFilas = 0;
			while (odbc_fetch_row($query)) {
				$numFilas++;
			}
			return $numFilas;
		}

		// funcion para generar un arreglo assoc a partir de una consulta
		function odbc_arreglo_assoc($query) {
			$i = 0;
			$filas = array();
			while ($fila = odbc_fetch_array($query, $i)) { 
				foreach ($fila AS $key => $value) {
					$filas[$i][$key] = $fila[$key];
				}
				$i++;
			}
			return $filas;
		}

		// funcion para respaldar todo
		function respaldarTabla($conexion, $SQL, $nombreTabla) {
				
			// variables:
			// $conexion = conexion a la BD mysql
			// $SQL = "SELECT * FROM vehiculos;";
			// $nombreTabla = "vehiculos";

			// generamos una nueva conexion a la BD donde se respaldara la informacion
			$dsnNuevo  	   = "test";
			$userNuevo 	   = "";
			$passNueva 	   = "";
			$conexionNueva = odbc_connect($dsnNuevo, $userNuevo, $passNueva);

			// ejecutamos el SQL SELECT * FROM tabla y obtenemos total de filas
			$consulta = EjecutarConsulta($conexion, $SQL);
			$numFilasTabla = mysqli_num_rows($consulta);

			// generamos un arreglo assoc con toda la info de la tabla
			$consulta = EjecutarConsulta($conexion, $SQL);
			$arregloTabla = obtener_todo($consulta);

			// obtengo el total de filas de la tabla espejo para saber si esta vacia
			$SQL_Filas = $SQL;
			$consultaFilasODBC = odbc_exec($conexionNueva, $SQL_Filas);
			$numFilasTablaODBC = odbc_total_filas($consultaFilasODBC);

			// eliminado de todos los datos en la tabla
			$SQL_delete = "DELETE FROM $nombreTabla;";
			odbc_exec($conexionNueva, $SQL_delete);

			// llenado de la BD de respaldo
			for ($x = 0; $x < $numFilasTabla; $x++) { 
				$IdVehiculo  = $arregloTabla[$x]["IdVehiculo"];
				$Propietario = $arregloTabla[$x]["Propietario"];
				$Placa = $arregloTabla[$x]["Placa"];
				$Tipo = $arregloTabla[$x]["Tipo"];
				$Uso = $arregloTabla[$x]["Uso"];
				$Annio = $arregloTabla[$x]["Anio"];
				$Color = $arregloTabla[$x]["Color"];
				$Puertas = $arregloTabla[$x]["Puertas"];
				$Modelo = $arregloTabla[$x]["Modelo"];
				$Marca = $arregloTabla[$x]["Marca"];
				$Transmision = $arregloTabla[$x]["Transmision"];
				$CapCarga = $arregloTabla[$x]["CapCarga"];
				$Serie = $arregloTabla[$x]["Serie"];
				$NumMotor = $arregloTabla[$x]["NumMotor"];
				$Linea = $arregloTabla[$x]["Linea"];
				$SubLinea = $arregloTabla[$x]["Sublinea"];
				$Cilindraje = $arregloTabla[$x]["Cilindraje"];
				$Combustible = $arregloTabla[$x]["Combustible"];
				$Origen = $arregloTabla[$x]["Origen"];

				$SQLnueva = "INSERT INTO $nombreTabla 
								VALUES ('$IdVehiculo',
												'$Propietario',
												'$Placa',
												'$Tipo',
												'$Uso',
												'$Annio',
												'$Color',
												'$Puertas',
												'$Modelo',
												'$Marca',
												'$Transmision',
												'$CapCarga',
												'$Serie',
												'$NumMotor',
												'$Linea',
												'$SubLinea',
												'$Cilindraje',
												'$Combustible',
												'$Origen')";

				odbc_exec($conexionNueva, $SQLnueva);
			}

			// cerramos la conexion a la BD de respaldo
			odbc_close($conexionNueva);
		}

		// respaldo de toda la BD en una base de datos de Access
			$SQL = "SELECT * FROM vehiculos;";
			respaldarTabla($Con, $SQL, "vehiculos");
		//ODBC
		if(!$vehiculos = new SimpleXMLElement('temp/XML/Vehiculos/Alta.xml', null, true)){
		}else{
			$nuevo = $vehiculos->addChild('vehiculo');
			$nuevo->addChild('Propietario',$Propietario);
			$nuevo->addChild('Placa',$Placa);
			$nuevo->addChild('Tipo',$Tipo);
			$nuevo->addChild('Modelo',$Modelo);
			$nuevo->addChild('Marca',$Marca);
			$nuevo->addChild('Anio',$Anio);
			$nuevo->addChild('Uso',$Uso);
			$nuevo->addChild('Color',$Color);
			$nuevo->addChild('NumPuertas',$numPuertas);
			$nuevo->addChild('Marca',$Marca);
			$nuevo->addChild('Transmision',$Transmision);
			$nuevo->addChild('CapacidadDeCarga',$capCarga);
			$nuevo->addChild('Serie',$Serie);
			$nuevo->addChild('NumMotor',$numMotor);
			$nuevo->addChild('Linea',$Linea);
			$nuevo->addChild('SubLinea',$Sublinea);
			$nuevo->addChild('Cilindraje',$Cilindraje);
			$nuevo->addChild('Combustible',$Combustible);
			$nuevo->addChild('Origen',$Origen); 
			$vehiculos->asXML('temp/XML/Vehiculos/Alta.xml');
		}
		echo "<script type='text/javascript'>alert('$msg');</script>";
		$SQL = "SELECT MAX(IdVehiculo) from vehiculos";
        $id = mysqli_fetch_row(EjecutarConsulta($Con, $SQL));
        header('Location: functions/lib/pdf/pdfConductores.php?idAux='.urlencode($id[0]));
	}elseif($affected == 0){
		$msg = "No fue posible registrar el vehículo";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}else{
		$msg = "Verifique que el propietario exista Y que la placa no este repetida";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

	Desconectar($Con);
}

?>