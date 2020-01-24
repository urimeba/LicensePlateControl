<div class="form">

    <header class="head">
        <h1>Cambios a conductor</h1>
    </header>

    <form id="form1" name="form1" method="POST" action="#">

        <div class="form__group">
            <input type="text" name="CURP" class="form__input" placeholder="CURP" maxlength="18" minlength="18">
            <label for="CURP" class="form__label">CURP</label>
        </div>

        <input type="submit" name="Submit" value="Buscar" class="sub2 btnAnimation"/>
    </form>


<?php

include('functions/rcon.php');

if(isset($_POST['SubmitUpdate'])){
    $Con = Conectar();
    $CURP = $_POST['CURP'];
    $Nombre = $_POST['Nombre'];
    $Domicilio = $_POST['Domicilio'];
    $GpoSanguineo = $_POST['GpoSanguineo'];
    $Restricciones = $_POST['Restricciones'];
    $TelEmergencia = $_POST['TelEmergencia'];
    $FechaNac = $_POST['FechaNac'];
    $SQL = "UPDATE Conductores SET Nombre = '$Nombre', Domicilio = '$Domicilio', GpoSanguineo = '$GpoSanguineo', Restricciones = '$Restricciones', TelEmergencia = '$TelEmergencia', FechaNac = '$FechaNac' WHERE CURP = '$CURP'";
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

if(isset($_POST['CURP'])){
    $CURP = $_POST['CURP'];
    $Con = Conectar();
    $SQL = "SELECT * FROM conductores WHERE CURP = '".$CURP."'";
    $Query = ejecutarConsulta($Con, $SQL);
    if(mysqli_num_rows($Query) > 0){
        $campos = mysqli_fetch_assoc($Query);

?>

        <div class="update">
        <form id="form2" name="form2" method="POST" action="#">
            <div class="form__group" style="display: none;">
                <input name="CURP" class="form__input" value="<?php echo($campos['CURP']); ?>">
                <label for="CURP" class="form__label">CURP</label>
            </div>
            <div class="form__group">
                <input name="CURP2" disabled class="form__input" value="<?php echo($campos['CURP']); ?>">
                <label for="CURP2" class="form__label">CURP</label>
            </div>
            <div class="form__group">
                <input type="text" name="Nombre" class="form__input" value="<?php echo($campos['Nombre']); ?>">
                <label for="Nombre" class="form__label">Nombre</label>
            </div>

            <div class="form__group">
                <input type="text" name="Domicilio" class="form__input" value="<?php echo($campos['Domicilio']); ?>">
                <label for="Domicilio" class="form__label">Domicilio</label>
            </div>

            <div class="form__group">
                <input type="checkbox" name="Donador" value="1" checked="checked" />
                <label>Donador</label>
            </div>

            <div class="form__group">
                <select name="GpoSanguineo" id="" class="form__input">
                    <option value="<?php echo($campos['GpoSanguineo']); ?>" slected><?php echo($campos['GpoSanguineo']); ?></option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
                <label for="GpoSanguineo" class="form__label">Grupo Sanguineo</label>
            </div>
            
            <div class="form__group">
                <select name="Restricciones" id="" class="form__input">
                    <option value="<?php echo($campos['Restricciones']); ?>" slected><?php echo($campos['Restricciones']); ?></option>
                    <option value="Usa Lentes">Usa Lentes</option>
                    <option value="Niguna">Ninguna</option>
                </select>
                <label for="Restricciones" class="form__label">Uso</label>
            </div>
            
            <div class="form__group">
                <input type="text" name="TelEmergencia" class="form__input" value="<?php echo($campos['TelEmergencia']); ?>">
                <label for="TelEmergencia" class="form__label">Telefono de Emergencia</label>
            </div>

            <div class="form__group">
                <input type="text" name="FechaNac" class="form__input" value="<?php echo($campos['FechaNac']); ?>">
                <label for="FechaNac" class="form__label">Fecha de Nacimiento</label>
            </div>

            <input type="submit" value="Actualizar" name="SubmitUpdate" class="sub2 btnAnimation"/>
        </form>
        </div>

<?php

    }else{
        $msg = "No se encontró un conductor con ese CURP";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    Desconectar($Con);    
}
?>
</div>