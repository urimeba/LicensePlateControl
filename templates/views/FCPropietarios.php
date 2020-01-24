<div class="form">

<header class="head">
	<h1>Reporte de propietarios</h1>
</header>

<form id="form1" name="form1" method="post" action="#">
	
	<div class="form__group">
		<input name="criterio" type="text" id="idVehiculo" class="form__input" placeholder="Criterio"/>
		<label class="form__label" for="criterio">Criterio</label>
	</div>

	<div class="form__group">
		<select name="atributo" id="atributo" class="form__input">
			<option value="RFC" selected="selected">RFC</option>
			<option value="CURP">CURP</option>
			<option value="Nombre">Nombre</option>
			<option value="Direccion">Dirección</option>
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
		$SQL = "SELECT * FROM propietarios WHERE ".$a." = '".$c."' OR ".$a." LIKE '%$c%';";
		$Query = ejecutarConsulta($Con, $SQL);
?>
<table class="consulta">
	<thead>
		<tr>
			<th>RFC</th>
			<th>CURP</th>
			<th>Nombre</th>
			<th>Dirección</th>
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