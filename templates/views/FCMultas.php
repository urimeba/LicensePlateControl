<div class="form">

<header class="head">
	<h1>Reporte de multas</h1>
</header>

<form id="form1" name="form1" method="post" action="#">
	
	<div class="form__group">
		<input name="criterio" type="text" id="idVehiculo" class="form__input" placeholder="Criterio"/>
		<label class="form__label" for="criterio">Criterio</label>
	</div>

	<div class="form__group">
		<select name="atributo" id="atributo" class="form__input">
			<option value="Folio" selected="selected">Folio</option>
			<option value="Licencia">Licencia</option>
			<option value="Vehiculo">Veh&iacute;culo</option>
			<option value="idOficial">idOficial</option>
			<option value="Monto">Monto</option>
			<option value="Lugar">Lugar</option>
			<option value="Hora">Hora</option>
			<option value="Fecha">Fecha</option>
			<option value="Motivo">Motivo</option>
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
		$SQL = "SELECT * FROM multas WHERE ".$a." = '".$c."' OR ".$a." LIKE '%$c%';";
		$Query = ejecutarConsulta($Con, $SQL);
?>
<table class="consulta">
	<thead>
		<tr>
			<th>Folio</th>
			<th>Vehiculo</th>
			<th>Licencia</th>
			<th>Monto</th>
			<th>Lugar</th>
			<th>Fecha</th>
			<th>Motivo</th>
			<th>IdOficial</th>
			<th>hora</th>
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