<div class="form">

<header class="head">
  <h1>Baja de propietarios</h1>
</header>

<form id="form1" name="form1" method="post" action="#">
  
  <div class="form__group">
    <input name="id" type="text" id="id" class="form__input" placeholder="RFC"/>
    <label class="form__label" for="id">RFC</label>
  </div>

  <input type="submit" name="Submit" value="Eliminar" class="sub2 btnAnimation"/>
</form>
</div>

<?php
  include('functions/rcon.php');
	if(isset($_POST['id'])){
		$AUX = $_POST['id'];
		$Con = Conectar();
		$SQL = "DELETE FROM propietarios WHERE RFC = '$AUX';";
    EjecutarConsulta($Con, $SQL);

    $affected = mysqli_affected_rows($Con);
    if($affected > 0){
      $msg = "Propietario eliminado de forma exitosa";
      echo "<script type='text/javascript'>alert('$msg');</script>";
    }elseif($affected == 0){
      $msg = "No fue posible eliminar el conductor debido a que tiene registros vinculados con este RFC";
      echo "<script type='text/javascript'>alert('$msg');</script>";
    }else{
      $msg = "Verifique que este conductor exista";
      echo "<script type='text/javascript'>alert('$msg');</script>";
    }

		Desconectar($Con);
	}
?>