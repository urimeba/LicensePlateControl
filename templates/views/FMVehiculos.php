<div class="form">

    <header class="head">
        <h1>Cambios a vehículo</h1>
    </header>

    <form id="form1" name="form1" method="POST" action="#">
        <!-- <p>VEHICULOS</p> -->

        <div class="form__group">
            <input type="number" name="folio" class="form__input" min="0">
            <label for="folio" class="form__label">Folio</label>
        </div>

        <input type="submit" name="Submit" value="Buscar" class="sub2 btnAnimation"/>
    </form>


<?php

include('functions/rcon.php');

if(isset($_POST['SubmitUpdate'])){
    $Con = Conectar();
    $id = $_POST['vehiculo'];
    $propietario = $_POST['propietario'];
    $placa = $_POST['placa'];
    $tipo = $_POST['tipo'];
    $uso = $_POST['uso'];
    $anio = $_POST['anio'];
    $color = $_POST['color'];
    $puertas = $_POST['puertas'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $transmision = $_POST['transmision'];
    $carga = $_POST['capCarga'];
    $serie = $_POST['serie'];
    $motor = $_POST['motor'];
    $linea = $_POST['linea'];
    $sublinea = $_POST['sublinea'];
    $cilindraje = $_POST['cilindraje'];
    $combustible = $_POST['combustible'];
    $origen = $_POST['origen'];
    $SQL = "UPDATE vehiculos 
        SET Propietario = '$propietario', Placa = '$placa', Tipo = '$tipo', Uso = '$uso', Anio = '$anio', Color = '$color', Puertas = '$puertas', Modelo = '$modelo', Marca = '$marca', Transmision = '$transmision', CapCarga = '$carga', Serie = '$serie', NumMotor = '$motor', Linea = '$linea', Sublinea = '$sublinea', Cilindraje = '$cilindraje', Combustible = '$combustible', Origen = '$origen' 
        WHERE IdVehiculo = '$id'";
    $Query = ejecutarConsulta($Con, $SQL);

    $affected = mysqli_affected_rows($Con);
    if($affected > 0){
      $msg = "Se actualizó la información correctamente";
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
                $Placa           = $arregloTabla[$x]["Placa"];
                $Tipo                = $arregloTabla[$x]["Tipo"];
                $Uso                 = $arregloTabla[$x]["Uso"];
                $Annio           = $arregloTabla[$x]["Anio"];
                $Color           = $arregloTabla[$x]["Color"];
                $Puertas         = $arregloTabla[$x]["Puertas"];
                $Modelo          = $arregloTabla[$x]["Modelo"];
                $Marca           = $arregloTabla[$x]["Marca"];
                $Transmision = $arregloTabla[$x]["Transmision"];
                $CapCarga        = $arregloTabla[$x]["CapCarga"];
                $Serie           = $arregloTabla[$x]["Serie"];
                $NumMotor    = $arregloTabla[$x]["NumMotor"];
                $Linea           = $arregloTabla[$x]["Linea"];
                $SubLinea    = $arregloTabla[$x]["Sublinea"];
                $Cilindraje  = $arregloTabla[$x]["Cilindraje"];
                $Combustible = $arregloTabla[$x]["Combustible"];
                $Origen          = $arregloTabla[$x]["Origen"];

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
      
      if(!$vehiculos = new SimpleXMLElement('temp/XML/Vehiculos/Cambios.xml', null, true)){
        }else{
            $nuevo = $vehiculos->addChild('vehiculo');
            $nuevo->addChild('IDVehiculo',$id);
            $nuevo->addChild('Propietario',$propietario);
            $nuevo->addChild('Placa',$placa);
            $nuevo->addChild('Tipo',$tipo);
            $nuevo->addChild('Modelo',$modelo);
            $nuevo->addChild('Marca',$marca);
            $nuevo->addChild('Anio',$anio);
            $nuevo->addChild('Uso',$uso);
            $nuevo->addChild('Color',$color);
            $nuevo->addChild('NumPuertas',$puertas);
            $nuevo->addChild('Marca',$marca);
            $nuevo->addChild('Transmision',$transmision);
            $nuevo->addChild('CapacidadDeCarga',$carga);
            $nuevo->addChild('Serie',$serie);
            $nuevo->addChild('NumMotor',$motor);
            $nuevo->addChild('Linea',$linea);
            $nuevo->addChild('SubLinea',$sublinea);
            $nuevo->addChild('Cilindraje',$cilindraje);
            $nuevo->addChild('Combustible',$combustible);
            $nuevo->addChild('Origen',$origen); 
            $vehiculos->asXML('temp/XML/Vehiculos/Cambios.xml');
        }
      echo "<script type='text/javascript'>alert('$msg');</script>";
    }elseif($affected == 0){
      $msg = "No fue posible realizar los cambios";
      echo "<script type='text/javascript'>alert('$msg');</script>";
    }else{
      $msg = "Hubo un error en la consulta";
      echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    Desconectar($Con);
}

if(isset($_POST['folio'])){
    $idVehiculo = $_POST['folio'];
    $Con = Conectar();
    $SQL = "SELECT * FROM vehiculos WHERE idVehiculo = '".$idVehiculo."'";
    $Query = ejecutarConsulta($Con, $SQL);
    if(mysqli_num_rows($Query) > 0){
        $campos = mysqli_fetch_assoc($Query);

?>

        <div class="update">
        <form id="form2" name="form2" method="POST" action="#">
            <div class="form__group"  style="display: none !important;">
                <input type="number" name="vehiculo" class="form__input" value="<?php echo($campos['IdVehiculo']); ?>">
                <label for="vehiculo" class="form__label">Folio</label>
            </div>

            <div class="form__group" style="display: none !important;">
                <input type="number" disabled name="vehiculo2" class="form__input" value="<?php echo($campos['IdVehiculo']); ?>">
                <label for="vehiculo2" class="form__label">Folio</label>
            </div>

            <div class="form__group">
                <input type="text" name="propietario" class="form__input" value="<?php echo($campos['Propietario']); ?>">
                <label for="propietario" class="form__label">Propietario</label>
            </div>

            <div class="form__group">
                <input type="text" name="placa" class="form__input" value="<?php echo($campos['Placa']); ?>">
                <label for="placa" class="form__label">Placa</label>
            </div>

            <div class="form__group">
                <select name="tipo" id="" class="form__input">
                    <option value="<?php echo($campos['Tipo']); ?>" slected><?php echo($campos['Tipo']); ?></option>
                    <option value="Automovil">Automovil</option>
                    <option value="Vehiculo Ligero">Vehículo Ligero</option>
                    <option value="Comercial">Comercial</option>
                    <option value="Turismo">Turismo</option>
                    <option value="Vehículo Especia/Agricola">Vehículo Especial/Agrícola</option>
                </select>
                <label for="tipo" class="form__label">Tipo</label>
            </div>
            
            <div class="form__group">
                <select name="uso" id="" class="form__input">
                    <option value="<?php echo($campos['Uso']); ?>" slected><?php echo($campos['Uso']); ?></option>
                    <option value="Particular">Particular</option>
                    <option value="Privado">Privado</option>
                </select>
                <label for="uso" class="form__label">Uso</label>
            </div>
            
            <div class="form__group">
                <input type="number" name="anio" class="form__input" value="<?php echo($campos['Anio']); ?>">
                <label for="anio" class="form__label">Año</label>
            </div>

            <div class="form__group">
                <input type="text" name="color" class="form__input" value="<?php echo($campos['Color']); ?>">
                <label for="color" class="form__label">Color</label>
            </div>

            <div class="form__group">
                <input type="number" name="puertas" class="form__input" value="<?php echo($campos['Puertas']); ?>">
                <label for="puertas" class="form__label">Puertas</label>
            </div>

            <div class="form__group">
                <input type="text" name="modelo" class="form__input" value="<?php echo($campos['Modelo']); ?>">
                <label for="modelo" class="form__label">Modelo</label>
            </div>

            <div class="form__group">
                <input type="text" name="marca" class="form__input" value="<?php echo($campos['Marca']); ?>">
                <label for="marca" class="form__label">Marca</label>
            </div>

            <div class="form__group">
                <select name="transmision" id="" class="form__input">
                    <option value="<?php echo($campos['Transmision']); ?>" slected><?php echo($campos['Transmision']); ?></option>
                    <option value="Automatica">Automática</option>
                    <option value="Estandar">Estandar</option>
                </select>
                <label for="transmision" class="form__label">Transmisión</label>
            </div>

            <div class="form__group">
                <input type="number" name="capCarga" class="form__input" value="<?php echo($campos['CapCarga']); ?>">
                <label for="capCarga" class="form__label">Capacidad de carga</label>
            </div>

            <div class="form__group">
                <input type="text" name="serie" class="form__input" value="<?php echo($campos['Serie']); ?>">
                <label for="serie" class="form__label">Serie</label>
            </div>

            <div class="form__group">
                <input type="text" name="motor" class="form__input" value="<?php echo($campos['NumMotor']); ?>">
                <label for="motor" class="form__label">Número de Motor</label>
            </div>

            <div class="form__group">
                <input type="text" name="linea" class="form__input" value="<?php echo($campos['Linea']); ?>">
                <label for="linea" class="form__label">Linea</label>
            </div>

            <div class="form__group">
                <input type="text" name="sublinea" class="form__input" value="<?php echo($campos['Sublinea']); ?>">
                <label for="sublinea" class="form__label">Sublinea</label>
            </div>
            
            <div class="form__group">
                <input type="number" name="cilindraje" class="form__input" value="<?php echo($campos['Cilindraje']); ?>">
                <label for="cilindraje" class="form__label">Cilindraje</label>
            </div>

            <div class="form__group">
                <select name="combustible" id="" class="form__input">
                    <option value="<?php echo($campos['Combustible']); ?>" slected><?php echo($campos['Combustible']); ?></option>
                    <option value="Gasolina">Gasolina</option>
                    <option value="Gas">Gas</option>
                    <option value="Electrico">Eléctrico</option>
                </select>
                <label for="combustible" class="form__label">Combustible</label>
            </div>

            <div class="form__group">
                <input type="text" name="origen" class="form__input" value="<?php echo($campos['Origen']); ?>">
                <label for="origen" class="form__label">Origen</label>
            </div>

            <input type="submit" value="Actualizar" name="SubmitUpdate" class="sub2 btnAnimation"/>
        </form>
        </div>

<?php

    }else{
        $msg = "No se encontró un vehiculo con ese folio";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    Desconectar($Con);    
}

?>

</div>