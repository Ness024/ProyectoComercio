<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <title>Home</title>
    <link rel="icon" href="Resources/gato.ico" type="image/x-icon">
</head>

<body>
    <header>
        <div>
            <a href="home.php"><img src="Resources/gatologo.png"></img></a>
            <h1>
                <a href="home.php">Gatito <span>Developer</span></a>
            </h1>
        </div>

        <form action="" id="searchForm">
            <input type="text" id="searchInput"/>
            <button type="submit"></button>
        </form>
        <div>
            <a href="Iniciar_Sesion.php" class="perfil">
                <img src="Resources/IconamoonProfileFill.svg" alt="" style="margin-right: 40px;">
            </a>
            <a href="carritoCompras.php" onclick="irAVerCarrito()">
                <span class="carritodeCompras">
                    <p id="carritoCont"></p>
                    <img src="Resources/SolarCartLargeMinimalisticBold.svg" alt="">
                </span>
            </a>
            <details>
                <summary>
                    <img src="Resources/menu-2.svg">
                </summary>
                <div class="animacionDiv"></div>
                <h3>Catergorias</h3>
                <ul class="detailsheader">
                    <?php
                    include 'db_connection.php';
                    $consultarCategorias = "SELECT * FROM categorias
                                        ORDER BY id DESC
                                        LIMIT 20;";
                    $stmt1 = $conexion->prepare($consultarCategorias);
                    $stmt1->execute();
                    $categorias = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php
                    if ($categorias) {
                        foreach ($categorias as $categoria) {
                            ?>
                            <li><a href="productosxCategoria.php?id=<?php echo $categoria['id']; ?>">
                                    <?php echo $categoria['nombre']; ?>
                                </a>
                            </li>
                        <?php }
                    } ?>
                </ul>
                <h3>Perfil</h3>
                <ul>
                    <li class="elemento"><a href="home.php">Home</a></li>
                    <li class="elemento"><a href="perfilDeUsuario.php?pagina=inicio">Datos Personales</a></li>
                    <li class="elemento"><a href="perfilDeUsuario.php?pagina=direccion">Direccion</a></li>
                    <li class="elemento"><a href="perfilDeUsuario.php?pagina=historial">Historial de compras</a></li>
                    <li class="elemento"><a href="perfilDeUsuario.php?pagina=pago">Metodo de pago</a></li>
                    <li class="elemento"><a href="perfilDeUsuario.php?pagina=favoritos">Favoritos</a></li>
                    <li class="elemento"><a href="paginasPerfil/cerrar_sesion.php">Cerrar sesion</a></li>
                </ul>
            </details>
        </div>
    </header>
<script >
    document.addEventListener('DOMContentLoaded', function () {
        verCantidad();
    });
</script>
<script src="scripts/buscar.js"></script>