<?php
require_once "../includes.php";


$num_sorteig= new Numeros();
$id_usu_sorteig = $num_sorteig->numero_pertany($_GET['num']);
$usu_complet = $num_sorteig->nom_usuari($id_usu_sorteig);


if($_POST['is_ajax']) {
	$resultat= 
		array(
			'element1' => $usu_complet
		);
	echo json_encode($resultat);
}
?>
