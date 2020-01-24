<div class="form">

<header class="head">
	<h1>Reporte de vehículos</h1>
</header>

<form id="form1" name="form1" method="post" action="#">

	<div class="form__group">
		<input name="criterio" type="text" id="criterio" class="form__input" placeholder="Criterio"/>
		<label class="form__label" for="criterio">Criterio</label>
	</div>

	<div class="form__group">
		<select name="atributo" id="atributo" class="form__input">
			<option value="IdVehiculo" selected="selected">Folio</option>
			<option value="Propietario">Propietario</option>
			<option value="Placa">Placa</option>
			<option value="Tipo">Tipo</option>
			<option value="Modelo">Modelo</option>
			<option value="Anio">Año</option>
			<option value="Uso">Uso</option>
			<option value="Color">Color</option>
			<option value="NumeroPuertas">Número de puertas</option>
			<option value="Marca">Marca</option>
			<option value="Transmision">Transmisión</option>
			<option value="CapacidadCarga">Capacidad de carga</option>
			<option value="Serie">Serie</option>
			<option value="NumeroMotor">Número del motor</option>
			<option value="Linea">Linea</option>
			<option value="Sublinea">Sublinea</option>
			<option value="Cilindraje">Cilindraje</option>
			<option value="Combustible">Combustible</option>
			<option value="Origen">Origen</option>
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
		$SQL = "SELECT * FROM vehiculos WHERE ".$a." = '".$c."' OR ".$a." LIKE '%$c%';";
		$Query = ejecutarConsulta($Con, $SQL);
?>
<table class="consulta">
	<thead>
		<tr>
			<th>ID</th>
			<th>Propietario</th>
			<th>Placa</th>
			<th>Tipo</th>
			<th>Modelo</th>
			<th>Año</th>
			<th>Uso</th>
			<th>Color</th>
			<th>Puertas</th>
			<th>Marca</th>
			<th>Transmision</th>
			<th>Cap. Carga</th>
			<th>Serie</th>
			<th>Numero de motor</th>
			<th>Linea</th>
			<th>Sublinea</th>
			<th>Cilindraje</th>
			<th>Combustible</th>
			<th>Origen</th>
		</tr>
	</thead>
	<tbody>
<?php		
		for($F=0;$F<mysqli_num_rows($Query);$F++){
			$Fila = mysqli_fetch_row($Query);?>
			<tr>
			<?php
			foreach($Fila as $i){
				echo("<th>".$i."</th>");
			}
			?>
			</tr>
			<?php
		}?>
	</tbody><?php
	
		Desconectar($Con);
	}
?>
</table>
</div>