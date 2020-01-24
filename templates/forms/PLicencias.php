<?php

include('functions/rcon.php');
if(isset($_POST['Submit'])){
    $Conductor= $_POST['conductor'];
    $Tipo= $_POST['tipo'];
    $fVencimiento= $_POST['fVencimiento'];
    $Lugar= $_POST['lugar'];
    $Expide= $_POST['expide'];
    $Foto= $_FILES['Foto'];

    $Foto['name']=$Conductor . ".png";
    
    $name = $Foto['name'];
    $location = "C:/xampp/htdocs/ControlVehicular/templates/img/Fotos/";
    $tmp_name = $Foto['tmp_name'];

    copy($tmp_name, $location.$name);
    move_uploaded_file($tmp_name, $location.$name);

    $location2=$location.$name;

    $hoy = date('Y-m-d');
    $v = null;
    if($fVencimiento == 3){
        $v = date('Y-m-d', strtotime('+3 years'));
    }else{
        $v = date('Y-m-d', strtotime('+5 years'));
    }

    $Con = Conectar();
    $SQL = "INSERT INTO licencias(Conductor, Expedicion, Tipo, Vencimiento, Lugar, Expide, Foto) 
        VALUES ('$Conductor', '$hoy', '$Tipo', '$v', '$Lugar', '$Expide','$location2')";
    EjecutarConsulta($Con,$SQL);

    $affected = mysqli_affected_rows($Con);
	if($affected > 0){
        $msg = "La licencia fue registrada correctamente";
        if(!$licencias = new SimpleXMLElement('temp/XML/Licencias.xml', null, true)){
        }else{
            $nuevo = $licencias->addChild('Licencia');
            $nuevo->addChild('Conductor',$Conductor);
            $nuevo->addChild('Expedicion',$hoy);
            $nuevo->addChild('Tipo',$Tipo);
            $nuevo->addChild('Vencimiento',$v);
            $nuevo->addChild('Lugar',$Lugar);
            $nuevo->addChild('Expide',$Expide);
            $nuevo->addChild('Foto',$location2);
        
            $licencias->asXML('temp/XML/Licencias.xml');
        }
        echo "<script type='text/javascript'>alert('$msg');</script>";
        $SQL = "SELECT MAX(IdLicencia) from licencias";
        $id = mysqli_fetch_row(EjecutarConsulta($Con, $SQL));
        header('Location: functions/lib/pdf/pdfLicencia.php?idAux='.urlencode($id[0]));
    }elseif($affected == 0){
        $msg = "Verifique que el conductor exista";
		echo "<script type='text/javascript'>alert('$msg');</script>";
    }else{
        $msg = "No fue posible registrar esta licencia, verifique que el conductor exista o que no tenga ya una licencia";
		echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    Desconectar($Con);
}

?>