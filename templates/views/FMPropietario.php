<div class="form">
    
    <header class="head">
        <h1>Cambios a propietario</h1>
    </header>
    
    <form id="form1" name="form1" method="POST" action="#">

        <div class="form__group">
            <input type="text" name="RFC" class="form__input" placeholder="RFC" maxlength="13" minlength="13">
            <label for="RFC" class="form__label">RFC</label>
        </div>

        <input type="submit" name="Submit" value="Buscar" class="sub2 btnAnimation"/>
    </form>


<?php

include('functions/rcon.php');

if(isset($_POST['SubmitUpdate'])){
    $Con = Conectar();
    $RFC = $_POST['RFC'];
    $CURP = $_POST['CURP'];
    $Nombre = $_POST['Nombre'];
    $Direccion = $_POST['Direccion'];
    $SQL = "UPDATE propietarios SET CURP = '$CURP', Nombre = '$Nombre', Direccion = '$Direccion' WHERE RFC = '$RFC'";
    $Query = ejecutarConsulta($Con, $SQL);

    $affected = mysqli_affected_rows($Con);
    if($affected > 0){
      $msg = "Se actualizó la información correctamente";
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

if(isset($_POST['RFC'])){
    $RFC = $_POST['RFC'];
    $Con = Conectar();
    $SQL = "SELECT * FROM propietarios WHERE RFC = '".$RFC."'";
    $Query = ejecutarConsulta($Con, $SQL);
    if(mysqli_num_rows($Query) > 0){
        $campos = mysqli_fetch_assoc($Query);

?>

        <div class="update">
        <form id="form2" name="form2" method="POST" action="#">
            <div class="form__group" style="display: none;">
                <input name="RFC" class="form__input" value="<?php echo($campos['RFC']); ?>">
                <label for="RFC" class="form__label">RFC</label>
            </div>
            <div class="form__group">
                <input name="RFC2" disabled class="form__input" value="<?php echo($campos['RFC']); ?>">
                <label for="RFC2" class="form__label">RFC</label>
            </div>
            <div class="form__group">
                <input type="text" name="CURP" class="form__input" value="<?php echo($campos['CURP']); ?>">
                <label for="CURP" class="form__label">CURP</label>
            </div>

            <div class="form__group">
                <input type="text" name="Nombre" class="form__input" value="<?php echo($campos['Nombre']); ?>">
                <label for="Nombre" class="form__label">Nombre</label>
            </div>

            <div class="form__group">
                <input type="text" name="Direccion" class="form__input" value="<?php echo($campos['Direccion']); ?>"/>
                <label for="Direccion" class="form__label">Direccion</label>
            </div>

            <input type="submit" value="Actualizar" name="SubmitUpdate" class="sub2 btnAnimation"/>
        </form>
        </div>

<?php

    }else{
        $msg = "No se encontró un propietario con ese RFC";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    Desconectar($Con);    
}

?>

</div>