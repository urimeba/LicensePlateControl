<div class="form">

<header class="head">
	<h1>Reporte de conductores</h1>
</header>

<form id="form1" name="form1" method="post" action="">
	
	<div class="form__group">
		<input name="criterio" type="text" id="idVehiculo" class="form__input" placeholder="Criterio"/>
		<label class="form__label" for="criterio">Criterio</label>
	</div>

	<div class="form__group">
		<select name="atributo" id="atributo" class="form__input">
			<option value="CURP">CURP</option>
			<option value="Nombre">Nombre</option>
			<option value="Domicilio">Domicilio</option>
			<option value="Donador">Donador</option>
			<option value="GpoSanguineo">Grupo sanguineo</option>
			<option value="Restricciones">Restricciones</option>
			<option value="TelEmergencia">Telefono de emergencia</option>
			<option value="FechaNac">Fecha de nacimiento</option>
		</select>
		<label class="form__label" for="atributo">Atributo</label>
	</div>
	
	<input type="submit" name="Submit" value="Consultar" class="sub2 btnAnimation"/>
</form>

<?php
	include('functions/rcon.php');
	if(isset($_POST['criterio'])){
		$c = $_POST['criterio'];
		$a = $_POST['atributo'];
		$Con = Conectar();
		$SQL = "SELECT * FROM conductores WHERE $a LIKE '%$c%';";
		$Query = ejecutarConsulta($Con, $SQL);
		// $_POST['Fila'] =mysqli_fetch_row($Query);
?>

<table class="consulta">
	<thead>
		<tr>
			<th>CURP</th>
			<th>Nombre</th>
			<th>Domicilio</th>
			<th>Firma</th>
			<th>Donador</th>
			<th>GpoSanguineo</th>
			<th>Restricciones</th>
			<th>TelEmergencia</th>
			<th>FechaNac</th>
		</tr>
	</thead>
	<tbody>
<?php		
		for($F=0;$F<mysqli_num_rows($Query);$F++){
			$Fila = mysqli_fetch_row($Query);
			print("
						
				<tr>
					<th>".$Fila[0]."</th>
					<th>".$Fila[1]."</th>
					<th>".$Fila[2]."</th>
					<th>".$Fila[3]."</th>
					<th>".$Fila[4]."</th>
					<th>".$Fila[5]."</th>
					<th>".$Fila[6]."</th>
					<th>".$Fila[7]."</th>
					<th>".$Fila[8]."</th>
				</tr>
			");
		}?>
	</tbody><?php
		Desconectar($Con);
	}
?>
</table>
</div>