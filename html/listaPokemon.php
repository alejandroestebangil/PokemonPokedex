<html>
<head>
<meta charset="UTF-8">
    <title>Pokedex</title>
    <link rel="stylesheet" href="estiloPokedex.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="/imagenes/favicon.ico">
</head>


<script>
    function redireccionar(url) {
        window.location.href = url;
    }

    function ordenar(field, order, tipo, nombre, pesomin, pesomax, alturamin, alturamax) {
        if (order == 'ASC' || order == "")
            orderby = 'DESC';
        else
            orderby = 'ASC';
        orderfield = field;
        
        document.location.href = window.location.href.split('?')[0] + "?orderfield=" + orderfield + "&orderby=" + orderby + "&tipo="+ tipo + "&nombre="+ nombre + "&pesomin="+ pesomin + "&pesomax=" + pesomax + "&alturamin=" + alturamin + "&alturamax=" + alturamax;
    }

    function filtrar(filtro){
        if (orderby == 'ASC')
            orderby = 'DESC';
        else
            orderby = 'ASC';
        
        ordenar(orderfield, orderby, filtro, nombre, pesomin, pesomax, alturamin, alturamax);
    }
    function limpiar(){
        document.location.href = window.location.href.split('?')[0];
    }

</script>

<body>
    <?php

    include 'config.php';
    include 'iconos.php';

    // Obtener el peso máximo de los Pokémon
    $sqlPesoMaximo = 'SELECT MAX(peso) as peso_maximo FROM pokemon';
    $resultPesoMaximo = mysqli_query($mysqli, $sqlPesoMaximo);
    $pesoMaximo = mysqli_fetch_assoc($resultPesoMaximo)['peso_maximo'];

    // Obtener la altura máxima de los Pokémon
    $sqlAlturaMaxima = 'SELECT MAX(altura) as altura_maxima FROM pokemon';
    $resultAlturaMaxima = mysqli_query($mysqli, $sqlAlturaMaxima);
    $alturaMaxima = mysqli_fetch_assoc($resultAlturaMaxima)['altura_maxima'];

    // Usar los valores obtenidos para establecer los límites de peso y altura
    $pesoMinimo = 0;
    $alturaMinima = 0;


    $orderfield = htmlentities($_GET['orderfield']);
    $order = htmlentities($_GET['orderby']);
    $tipo = $_GET['tipo'];
    $nombre = htmlentities($_GET['nombre'] ?? '');
    $pesomin = htmlentities($_GET['pesomin'] ?? '');
    $pesomax = htmlentities($_GET['pesomax'] ?? $pesomaximo);
    $alturamin = htmlentities($_GET['alturamin'] ?? '');
    $alturamax = htmlentities($_GET['alturamax'] ?? $alturamaxima);

    $sql = 'SELECT * FROM pokemon p ';
    $conditions = array();
    $order = 'ASC';

    if (isset($tipo) && $tipo != ""){
        $sql = "SELECT p.*, t.nombre as tipo FROM pokemon p 
                INNER JOIN pokemon_tipo pt ON p.numero_pokedex = pt.numero_pokedex
                INNER JOIN tipo t ON pt.id_tipo = t.id_tipo ";
        $conditions[] = "t.nombre = '$tipo'";
    }

    if (isset($nombre) && $nombre != "") {
        $conditions[] = "p.nombre LIKE '%$nombre%'";
    }
    if (isset($pesomin) && $pesomin != "") {
        $conditions[] = "p.peso >= $pesomin";
    }
    if (isset($pesomax) && $pesomax != "") {
        $conditions[] = "p.peso <= $pesomax";
    }
    if (isset($alturamin) && $alturamin != "") {
        $conditions[] = "p.altura >= $alturamin";
    }
    if (isset($alturamax) && $alturamax != "") {
        $conditions[] = "p.altura <= $alturamax";
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    if (isset($orderfield)&& $orderfield != "")
        $sql = $sql . 'ORDER BY p.'. $orderfield;
    else
        $sql = $sql . 'ORDER BY p.numero_pokedex';
    
    if (isset($order)&& $order != "")
        $sql = $sql . " " .$order;
    else
        $sql = $sql . " ASC";


    //echo "<p>Query: " . $sql . "<p>";
    $result = mysqli_query($mysqli, $sql);
    $movisFiltrados = 0;

    if (!$result) {
        die('Invalid query: ' . mysqli_error($mysqli));
    } else {
    // echo "<p>Query correcto<p>";
    echo '

    <div class="tapafiltro" id="tapafiltro">
        <img src="imagenes/filtrar.png" id="imagen" onclick="document.getElementById(\'imagen\').style.display = \'none\'">

        <table class="filtros">
            <form id="filtro" name="filtro" method="get" action="listaPokemon.php">
                <tr>
                    <td class="content-select">
                        <select id="tipo" onchange=filtro.submit()>
                            <option value="">Tipo</option>';
                            $sqlTipo = 'SELECT nombre FROM tipo';
                            $resultTipo = mysqli_query($mysqli, $sqlTipo);
                            while ($row2 = mysqli_fetch_assoc($resultTipo)) {
                                if ($row2['nombre'] == $tipo)
                                    echo "<option value='" . $row2['nombre'] . "' selected>" . $row2['nombre'] . "</option>";
                                else
                                    echo "<option value='" . $row2['nombre'] . "'>" . $row2['nombre'] . "</option>";
                            }
                        echo '
                        </select><i></i>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre</td>
                    <td class="content-select">
                        <input name="nombre" id="nombre" onchange="filtro.submit()" value="'.$nombre.'">
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;KG Mín</td>
                    <td class="content-select">
                        <input type="number" min="0" max="'.$pesomaximo.'" name="pesomin" id="pesomin" onchange="filtro.submit()" value="'.$pesomin.'">
                    </td>
                    <td>KG Máx</td>
                    <td class="content-select">
                        <input type="number" min="0" max="'.$pesomaximo.'" name="pesomax" id="pesomax" onchange="filtro.submit()" value="'.$pesomax.'">
                    </td>
                    <td>Altura Mín</td>
                    <td class="content-select">
                        <input type="number" min="0" max="'.$alturamaxima.'" name="alturamin" id="alturamin" step=0.1 onchange="filtro.submit()" value="'.$alturamin.'">
                    </td>
                    <td>Altura Máx</td>
                    <td class="content-select">
                        <input type="number" min="0" max="'.$alturamaxima.'" name="alturamax" id="alturamax" step=0.1 onchange="filtro.submit()" value="'.$alturamax.'">
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;Ordenar por</td>
                    <td class="content-select">
                        <select name="orderfield" id="orderfield" required onchange="filtro.submit()">
                            <option value="numero_pokedex"';
                            if ($orderfield == "numero_pokedex")
                                echo ' selected';
                            echo '>Nº Pokedex</option>
                            <option value="nombre"';
                            if ($orderfield == "nombre")
                                echo ' selected';
                            echo '>Nombre</option>
                            <option value="peso"';
                            if ($orderfield == "peso")
                                echo ' selected';
                            echo '>Peso</option>
                            <option value="altura"';
                            if ($orderfield == "altura")
                                echo ' selected';
                            echo '>Altura</option>
                        </select><i></i>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Orden</td>
                    <td class="content-select">
                        <select name="orderby" id="orderby" onchange="filtro.submit()">
                            <option value="ASC"';
                            if ($order == "ASC")
                                echo ' selected';
                            echo '>Ascendente</option>
                            <option value="DESC"';
                            if ($order == "DESC")
                                echo ' selected';
                            echo '>Descendente</option>
                        </select><i></i>
                    </td>
                </tr>
            </form>
        </table>
        </div>';

        
        echo "<br><br>";
        while ($row = mysqli_fetch_assoc($result)) {
            $imagen = "src=https://assets.pokemon.com/assets/cms2/img/pokedex/full/" . sprintf("%03d", $row['numero_pokedex']) . ".png";
        
        
        echo "<table class='card'>
                <tr>
                    <th style='text-align: center;'>Nº " . $row['numero_pokedex'] . "</th>
                    <th style='text-align: center;' colspan=2>" . " " . strtoupper($row['nombre']) . "</th>
                </tr>
                <tr>
                    <td colspan=3>
                        <img class='portada' $imagen onclick=editar(" . $row['numero_pokedex'] . ")>
                        </img>
                    </td>
                </tr>
                <tr>
                    <td style='text-align: center;'><b>" . $row['peso'] . " kg</b></td>
                    <td style='text-align: center;'><b>" . $row['altura'] . " m</b></td>
                </tr>";


        $sqlTipo = 'SELECT t.nombre as tipo
                FROM pokemon p
                    INNER JOIN pokemon_tipo pt
                        on p.numero_pokedex = pt.numero_pokedex
                    INNER JOIN tipo t 
                        on pt.id_tipo = t.id_tipo
                    WHERE p.numero_pokedex = ' . $row['numero_pokedex'] . ';';
        $result2 = mysqli_query($mysqli, $sqlTipo);
        
        
        echo "<tr></td>";
        
        
        while ($row2 = mysqli_fetch_assoc($result2)) {
            foreach ($row2 as $col2) {
                echo "<td onclick=ordenar('".$orderfield ."','".$order. "','".$col2 . "','".$nombre."',".$pesomin ."," .$pesomax,"," .$alturamin ."," .$alturamax.")><div class='tipo'>" . $col2 . "</div></td>";
            }
        }
    
    }
    echo "</table>";
    }
    
    include 'close.php';
    ?>

</body>

</html>
