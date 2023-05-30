<!DOCTYPE html>
<html>

<head>
	<title>Eliminar Pokemon</title>
	<link rel="stylesheet" href="estiloPokedex.css" type="text/css">
	<link rel="icon" type="image/x-icon" href="/imagenes/favicon.ico">
</head>

<body>
	<?php

	include 'config.php';
    include 'iconos.php';

	$numero_pokedex = htmlentities($_GET['numero_pokedex']);
	$nombre = htmlentities($_GET['nombre']);
	$altura = htmlentities($_GET['altura']);
	$peso = htmlentities($_GET['peso']);

	$sql = 'DELETE FROM pokemon WHERE numero_pokedex =' . $numero_pokedex;

	$resultado = mysqli_query($mysqli, $sql);
	if ($resultado) {
		//echo "<h2>Eliminación correcta</h2>
			//<h3>Redirigiendo a la página principal...</h3>";
		$sql2 = 'SELECT MAX(id) FROM Borrados;';
		$resultado2 = mysqli_query($mysqli, $sql2);
		$id = mysqli_fetch_array($resultado2);
		$sql3 = "UPDATE  Borrados SET ip_cliente = '" . $_SERVER['REMOTE_ADDR'] . "',
										user_agent = '" . $_SERVER['HTTP_USER_AGENT'] . "'
				WHERE id =". $id[0] .';';
		$resultado3 = mysqli_query($mysqli, $sql3);
	} 
	
	include "close.php";
	?>


</body>

</html>