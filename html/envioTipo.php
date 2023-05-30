<html>
<head>
<title>Envio de datos</title>
</head>
<body>
<?php
//recuperamos los datos del formulario.php
//y los guardamos en variables
$tipo1 = $_GET['tipo1'];
$tipo2 = $_GET['tipo2'];
//comprobamos si tipo 2 is set
$sql = "select nombre,altura,peso from pokemon where tipo='".$tipo1."'"
if(isset($tipo2)){
  $sql = $sql." and tipo='".$tipo2."'"
} 
$sql = $sql.";"
echo $sql
// launch sql query
// create a connection  

$mysqli = mysqli_connect("172.17.0.2", "root", "2003", "pokemondb");
echo "conectado a database";
if (!$mysqli) {
	echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
	echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
	exit;
    }
    
    echo "Éxito: Se realizó una conexión apropiada a MySQL! La base de datos mi_bd es genial." . PHP_EOL;
$result = mysqli_query($mysqli, $sql);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}else{

	    echo "query ok";
	    // iterate over all rows

      echo '<table class="misestilos">';
        while ($row = mysqli_fetch_assoc($result)) {
	        // iterate over all columns
          echo "<tr>";
	        foreach ($row as $col) {
	            echo "<td>".$col."</td>";
	        }
          echo "</tr>";
	    } 

      echo "</table>";
      mysqli_close($mysqli);
}


mysqli_query($conn)
?>

<div>quiero consultar por tipo</div>
<form action="envioTipo.php" method="get">
Tipo1: <input type="text" name="tipo1" size="20"><br>
Tipo2: <input type="text" name="tipo2" size="20"><br>
<input type="submit" value="enviar tipos"/>
</form>

<div>quiero consultar por peso y altura</div>
<form action="infoPesoAltura.php" method="get">
Altura: <input type="text" name="altura" size="20"><br>
Peso: <input type="text" name="peso" size="20"><br>
<input type="submit" value="enviar altura peso"/>
</form>
</body>
