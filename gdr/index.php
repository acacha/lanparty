<?php
	require_once('functions.php');
	



?>
<!DOCTYPE html>
<html>
	<head>  
		<meta charset="utf-8">
		<meta name="author" content="Pau Ferrer Ocaña"/>
		<meta name="copyright" content="Copyright &copy;2009-<?php echo date('Y'); ?> Pau Ferrer Ocaña"/>
		<meta name="generator" content="Institut de l'Ebre"/>
		<title>Grand Dice Roll</title>
		<link rel="stylesheet" href="style.css"/>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
function num(num_resultat){
	$.ajax({
		url:'prova_ajax.php?num='+num_resultat+'' ,
		data: {
			is_ajax: 'true'
		},
		type: 'post',
		dataType: 'json'
		}).done(
		function(resp)
		{
			$("#resultat").html('Felicitats! <br>'+ resp.element1);
			
		}
	).fail(
		function() 
		{
			alert( "error" );
		});
		
		
		
		}
	</script>
		<script >
		var maxim;
var vel;
var plus;
var stop = 1500;
var finished = false;
var minim = 2;
var results = new Array();
var tirada = 0;

function onLoad(max, tirades){
	deleteHint();
	document.onkeyup = KeyCheck;
	
	if(max <= 0) return;
	
	maxim = max;

	
	var sense_repetir = max >= tirades;
	
	var value;
	for(var i = 0; i < tirades; ){
		value = roll();
		if(sense_repetir){
			var trobat = false;
			for(var j in results) {
				if(results[j] == value){ 
					trobat = true;
					break;
				}
			}
			if(!trobat){
				results.push(value);
				i++;
			}
		} else{
			results.push(value);
			i++;
		}
	}
	document.getElementById('results').innerHTML = results.join(';') ;
	tirar();
}

function tirar(){
	finished = false;
	document.getElementById("dice").setAttribute("class", "");
	vel = 1000.1;
	plus = 0.75;
	deleteHint();
	main();
}


function main(){
	vel = vel * plus;
	
	if(vel < minim){
		setHint('Premeu una tecla per parar el dau');
		vel = 2;
	}
	
	if(vel > stop){
		document.getElementById('result').innerHTML = results[tirada];
		document.getElementById("dice").setAttribute("class", "finished");
		finished = true;
		
	 
	 
		if(tirada+1 < results.length){
/*
CODI EXTRA
*/
		setHint('<div id="resultat"><p style="color:#ffffff;"> Buscant... <br></p> <img src="loading.gif" height="75" width="75"></img></div> ');
		
		setTimeout(function(){num(results[tirada])}, 10000);
		//num(results[tirada]);

			
 
		}else
			setHint('Felicitats! S\'ha acabat el sorteig');
	}
	else{
		document.getElementById('result').innerHTML = roll();
		setTimeout('main()',vel);
	}
}
 

function KeyCheck(event){
	if(finished){
		tirada++;
		if(tirada < results.length)
			tirar();
	} else {
		//Canviem la velocitat per parar
		if(plus < 1) plus = 1 / plus;
		deleteHint();
	}
	return false;
}

function roll(){
	return Math.ceil(Math.random() * maxim);
}


function setHint(text){
	document.getElementById("hint").style.visibility ='visible';
	document.getElementById('hint').innerHTML = text;
}

function deleteHint(){
	document.getElementById("hint").style.visibility ='hidden';
	document.getElementById('hint').innerHTML = '.';
}

		</script>
	</head>
<body>
	<div id="content">
<?php

	$max = isset($_REQUEST["max"])? $_REQUEST["max"] : false;
	if($max <= 0) $max = false;
	$tirades = isset($_REQUEST["tirades"])? $_REQUEST["tirades"] : false;
	if($tirades <= 0) $tirades = false;
	if($max && $tirades) print_dice($max,$tirades);
	else print_instructions();
?>
	</div>
</body>
</html>
