<div class="form">

<header class="head">
  <h1>Baja de conductores</h1>
</header>

<form id="form1" name="form1" method="post" action="#">
  
  <div class="form__group">
    <input name="CURP" type="text" id="CURP" maxlength="18" minlength="18" class="form__input" placeholder="CURP"/>
    <label class="form__label" for="CURP">CURP</label>
  </div>
  
  <input type="submit" name="Submit" value="Eliminar" class="sub2 btnAnimation"/>
</form>
</div>

<?php

include('functions/rcon.php');
if(isset($_POST['CURP'])){
  $CURP = $_POST['CURP'];
  $Con = Conectar();
  //SELECT
  $SQL = "SELECT * FROM conductores WHERE CURP = '$CURP';";

  $resultado=EjecutarConsulta($Con, $SQL);

  $row = mysqli_fetch_array($resultado);

  $CURP = $row[0];
  $Nombre = $row[1];
  $Domicilio = $row[2];
  $location2 = $row[3];
  $Donante = $row[4];
  $GrupoS = $row[5];
  $Restricciones = $row[6];
  $TelE = $row[7];  
  $FechaN = $row[8];
  
  //DELETE DE LA BD
  $SQL = "DELETE FROM conductores WHERE CURP = '$CURP';";
  EjecutarConsulta($Con, $SQL);

  $affected = mysqli_affected_rows($Con);
	if($affected > 0){
		$msg = "Conductor eliminado de forma exitosa";
    //XML
    if(!$conductores = new SimpleXMLElement('temp/XML/ConductoresBaja.xml', null, true)){
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
    
      $conductores->asXML('temp/XML/ConductoresBaja.xml');
    }
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}elseif($affected == 0){
		$msg = "No fue posible eliminar el conductor debido a que tiene registros vinculados con este CURP";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}else{
		$msg = "Verifique que este conductor exista";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}

  Desconectar($Con);
}

?>
