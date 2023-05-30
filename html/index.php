<html>

<head>
    <title>Pokedex</title>
    <link rel="stylesheet" href="estiloIndice.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="/imagenes/favicon.ico">
</head>

<body>

    <form id="busqueda" action="listaPokemon.php" method="get">
        <div class="center-on-page">
            <div class="pokeball" onclick="window.location.href='listaPokemon.php';">
                <div class="pokeball__button"></div>
                <div class="edicion" onclick="busqueda.submit()"></div>
            </div>
        </div>
    </form>



    <div class="fondo">
        <img src="imagenes/fondoIndice.jpg" alt="fondo">
    </div>

    

</body>

</html>