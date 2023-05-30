<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>

<HEAD>
  <TITLE> Formulario Insertar </TITLE>
  <link rel="stylesheet" href="estiloPokedex.css" type="text/css">
  <link rel="icon" type="image/x-icon" href="/imagenes/favicon.ico">

</HEAD>

<BODY>
  <h1>Insertar Pokemon</h1>
  <?php
  include 'config.php';
  include 'iconos.php';
  $sql = 'SELECT numero_pokedex FROM pokemon ORDER BY numero_pokedex DESC LIMIT 1';
  $result = mysqli_query($mysqli, $sql);
  $fila = mysqli_fetch_assoc($result);
  $siguienteNumero = $fila['numero_pokedex'] + 1;


  include "close.php";
  ?>
  <br><br><br><br>
  <table class="card">
    <form id="insertar" name="insertar" method="get" action="insertarPokemon.php">
      <th colspan=2 style="text-align:center">Crear Pokemon</th>
      <tr>
        <td>Nº Pokedex</td>
        <td><input required type="number" name="numero_pokedex" id="numero_pokedex" value="<?php echo $siguienteNumero ?>" ></td>
      <tr>
        <td>Nombre</td>
        <td><input required type="text" name="nombre" id="nombre" autofocus></td>
      </tr>
      <tr>
        <td>Peso</td>
        <td><input required type="number" min="0" max="1000" step="0.1" name="peso" id="peso"></td>
      </tr>
      <tr>
        <td>Altura</td>
        <td><input required type="number" name="altura" min="0" max="100" step="0.1" id="altura"></td>
      </tr>
      <tfoot>
        <tr>
          <td colspan=2>
            <input type=image class="submit" src="./imagenes/nuevo.png">
          </td>
        </tr>
      </tfoot>
    </form>
  </table>
  

</BODY>

</HTML>