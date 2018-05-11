<?php
require_once "../includes.php";

function print_dice($max, $tirades){
	
	echo '<div id="dice">';
	echo '<div id="hint"></div>';
	echo '<div id="result">'.$max.'</div>';
	echo '</div>';
	echo '<div id="results"></div>';
	echo '<script>window.onload=function(){onLoad('.$max.','.$tirades.');}</script>';
}

function print_instructions(){
	?>
	<h1>Grand Dice Roll</h1>
	<div id="instructions">
		<p><b>Instruccions:</b></p>
		<p>Escriure el número de cares, prèmer la tecla retorn.<br />Per parar el dau, prèmer una tecla.</p>
	
	<?php
	$numero_total = new Numeros();
	$numero_total = $numero_total->num_max();
	?>	
	
		<form method="post">
			<label for="max">Núm. total d'assignacions:</label><br />
			<input maxlength="5" name="max" id="max" size="5" type="text" value="<?=$numero_total?>"><br>
			<label for="tirades">Tirades:</label><br />
			<input maxlength="5" name="tirades" id="tirades" size="5" type="text"><br>
			<input type="submit">
		</form>
	</div>
	<?php
}
