<div class="form">

<header class="head">
	<h1>Reporte de verificaciones</h1>
</header>

<form id="form1" name="form1" method="post" action="#">
	
	<div class="form__group">
		<input name="criterio" type="text" id="idVehiculo" class="form__input" placeholder="Criterio" required/>
		<label class="form__label" for="criterio">Criterio</label>
	</div>

	<div class="form__group">
		<select name="atributo" id="atributo" class="form__input">
			<option value="Folio" selected="selected">Folio</option>
			<option value="Vehiculo">Vehiculo</option>
			<option value="Fecha">Fecha</option>
			<option value="Periodo">Periodo</option>
			<option value="Dictamen">Dictamen</option>
		</select>
		<label class="form__label" for="stributo">Atributo</label>
	</div>
	
	<input type="submit" name="Submit" value="Consultar" class="sub2 btnAnimation"/>
</form>

<?php 
	include('functions/rcon.php');
	if(isset($_POST['criterio'])){
		$c = $_POST['criterio'];
		$a = $_POST['atributo'];
		$Con = Conectar();
		$SQL = "SELECT * FROM verificaciones WHERE ".$a." = '".$c."' OR ".$a." LIKE '%$c%';";
		$Query = ejecutarConsulta($Con, $SQL);
?>
<table class="consulta">
	<thead>
		<tr>
			<th>ID</th>
			<th>Vehiculo</th>
			<th>Fecha</th>
			<th>Periodo</th>
			<th>Dictamen</th>
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