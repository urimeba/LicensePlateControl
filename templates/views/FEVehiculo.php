<div class="form">

  <header class="head">
    <h1>Baja de vehículos</h1>
  </header>
  
  <form id="form1" name="form1" method="post" action="#">
    <div class="form__group">
      <input name="id" type="number" id="id" class="form__input" placeholder="ID Vehículo" min="1"/>  
      <label for="id" class="form__label">ID Vehículo</label>
    </div>
  
    <input type="submit" name="Submit" value="Eliminar" class="sub2 btnAnimation"/>
  </form>
</div>

<?php
include('functions/rcon.php');
if(isset($_POST['id'])){
  $AUX = $_POST['id'];
  $Con = Conectar();
    //SELECT
  $SQL = "SELECT * FROM vehiculos WHERE IdVehiculo = '$AUX';";
  $resultado=EjecutarConsulta($Con, $SQL);
  $row = mysqli_fetch_array($resultado);

  $IdVehiculo = $row[0];
  $Propietario = $row[1];
  $Placa = $row[2];
  $Tipo = $row[3];
  $Uso = $row[4];
  $Anio = $row[5];
  $Color = $row[6];
  $Puertas = $row[7];  
  $Modelo = $row[8];
  $Marca = $row[9];
  $Transmision = $row[10];
  $capCarga = $row[11];
  $Serie = $row[12];
  $numMotor = $row[13];
  $Linea = $row[14];
  $Sublinea = $row[15];
  $Cilindraje = $row[16];
  $Combustible = $row[17];
  $Origen = $row[18];

    //DELETE DE LA BD
  $SQL = "DELETE FROM vehiculos WHERE IdVehiculo = '$AUX';";
  EjecutarConsulta($Con, $SQL);

  $affected = mysqli_affected_rows($Con);
	if($affected > 0){
		$msg = "Vehículo eliminado de forma exitosa";
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
      $dsnNuevo      = "test";
      $userNuevo     = "";
      $passNueva     = "";
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
        $Placa       = $arregloTabla[$x]["Placa"];
        $Tipo        = $arregloTabla[$x]["Tipo"];
        $Uso         = $arregloTabla[$x]["Uso"];
        $Annio       = $arregloTabla[$x]["Anio"];
        $Color       = $arregloTabla[$x]["Color"];
        $Puertas     = $arregloTabla[$x]["Puertas"];
        $Modelo      = $arregloTabla[$x]["Modelo"];
        $Marca       = $arregloTabla[$x]["Marca"];
        $Transmision = $arregloTabla[$x]["Transmision"];
        $CapCarga    = $arregloTabla[$x]["CapCarga"];
        $Serie       = $arregloTabla[$x]["Serie"];
        $NumMotor    = $arregloTabla[$x]["NumMotor"];
        $Linea       = $arregloTabla[$x]["Linea"];
        $SubLinea    = $arregloTabla[$x]["Sublinea"];
        $Cilindraje  = $arregloTabla[$x]["Cilindraje"];
        $Combustible = $arregloTabla[$x]["Combustible"];
        $Origen      = $arregloTabla[$x]["Origen"];

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
    //XML
    if(!$vehiculos = new SimpleXMLElement('temp/XML/Vehiculos/Baja.xml', null, true)){
    }else{
      $nuevo = $vehiculos->addChild('vehiculo');
      $nuevo->addChild('IdVehiculo',$IdVehiculo);
      $nuevo->addChild('Propietario',$Propietario);
      $nuevo->addChild('Placa',$Placa);
      $nuevo->addChild('Tipo',$Tipo);
      $nuevo->addChild('Modelo',$Modelo);
      $nuevo->addChild('Marca',$Marca);
      $nuevo->addChild('Anio',$Anio);
      $nuevo->addChild('Uso',$Uso);
      $nuevo->addChild('Color',$Color);
      $nuevo->addChild('NumPuertas',$Puertas);
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
      $vehiculos->asXML('temp/XML/Vehiculos/Baja.xml');
    }
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}elseif($affected == 0){
		$msg = "No fue posible eliminar el vehículo, verifique que este vehículo exista";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}else{
		$msg = "Verifique que este vehículo exista";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

  Desconectar($Con);
}
?>