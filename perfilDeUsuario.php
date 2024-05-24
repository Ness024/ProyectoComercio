<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header('Location: Iniciar_Sesion.php');
}

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

        <form action="">
            <input type="text" />
            <button></button>
        </form>
        <div>
            <a href="Iniciar_Sesion.php" class="perfil">
                <img src="Resources/IconamoonProfileFill.svg" alt="" style="margin-right: 40px;">
            </a>
            <a href="carritoCompras.php" onclick="irAVerCarrito()">
                <span class="carritodeCompras">
                    <p id="carritoCont">0</p>
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
    <main>
        <aside id="sidebar">
            <div class="toggle">
                <div class="toggle-menu">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </div>
            <h2>Tu cuenta</h2>
            <ul class="contenedor">
                <li class="elemento"><a href="home.php">Home</a></li>
                <li class="elemento"><a href="perfilDeUsuario.php?pagina=inicio">Datos Personales</a></li>
                <li class="elemento"><a href="perfilDeUsuario.php?pagina=direccion">Direccion</a></li>
                <li class="elemento"><a href="perfilDeUsuario.php?pagina=historial">Historial de compras</a></li>
                <li class="elemento"><a href="perfilDeUsuario.php?pagina=pago">Metodo de pago</a></li>
                <li class="elemento"><a href="perfilDeUsuario.php?pagina=favoritos">Favoritos</a></li>
                <li class="elemento"><a href="paginasPerfil/cerrar_sesion.php">Cerrar sesion</a></li>
                <!--<li class="elemento"><a href="verfoto.html">Ver mas</a></li>-->
            </ul>
        </aside>
        <?php
        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'inicio';

        switch ($pagina) {
            case 'inicio':
                include 'paginasPerfil/informacionPersonal.php';
                break;
            case 'direccion':
                include 'paginasPerfil/direccion.php';
                break;
            case 'historial':
                include 'paginasPerfil/HistorialdeCompras.php';
                break;
            case 'pago':
                include 'paginasPerfil/formaPago.php';
                break;
            case 'favoritos':
                include 'paginasPerfil/favoritos.php';
                break;
            default:
                break;
        }
        ?>
    </main>
    <footer>
        <div class="footer-top">
            <div class="footer-texto">
                <h1>GatitoDeveloper Is God...</h1>
                <h3>"Donde las patas dejan huella y los ronroneos se convierten en melodía.
                    Tu tienda de confianza para consentir a tus mascotas,
                    uniendo corazones peludos con productos de calidad."</h3>
            </div>
            <div class="footer-img">
                <img src="Resources/Gatologo.png" alt="img Footer">
            </div>
        </div>
        <div class="footer-principal">
            <div class="principal-arriba">
                <div class="arriba-texto">
                    <h1>GATITODEVELOPER</h1>
                    <h3>"En cada huella, un lazo de amor."</h3>

                    <form method="" action="" class="form-login">
                        <fieldset>
                            <input id="buscar" name="buscar" type="text" class="input" placeholder="Buscar" required />
                        </fieldset>
                        <button type="submit"><img src="Resources/huella.png" alt="huella"></button>
                    </form>
                </div>
                <div class="arriba-img">
                    <img src="Resources/sale.png" alt="">
                </div>
            </div>
        </div>
        <div class="footer-final">
        </div>
    </footer>
</body>
<style>
    #sidebar.active {
        left: -320px;
        width: 0px;
    }


    body {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: auto 1fr auto;
        grid-template-areas:
            "header"
            "main"
            "footer";
        min-height: 100vh;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    main {
        grid-area: main;
        padding: 35px;
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    .boton {
        position: absolute;
        left: 25%;
    }



    /******* */
    .form-grupo {
        width: -webkit-fill-available;
        margin-bottom: 5px;
        padding-top: 10px;
        margin-right: 42px;
    }

    fieldset {
        display: flex;
        flex-direction: row;

        border: transparent;
        padding: 15px;
        font-weight: bold;
        font-size: 16px;
        color: black;
    }

    .span,
    .input {
        font: 16px/16px Verdana;
        padding: 0;
    }

    .label,
    .label-editado {
        display: block;
        width: 100%;
        border: 1px solid #2386c7;
        padding: 8px 10px;
        position: relative;
        box-sizing: border-box;
        border-radius: 4px;
        transition: .25s;

    }

    .label-editado {
        border: transparent;
    }

    .label input,
    .label-editado input {
        display: block;
        width: 100%;
        border: none;
        background: transparent;
        outline: none;
        padding: 6px;
    }

    .label.focus {
        border-color: #2386c7;
    }

    .label .span.focus {
        color: #2386c7;
    }

    .label .span.top {
        left: 2px;
        top: -10px;
        font-size: 12px;
        background: white;
        padding: 0 5px;
    }

    .label .span,
    .label-editado .span {
        color: #2386c7;
        position: absolute;
        left: 2px;
        top: -10px;
        font-size: 14px;
        background: white;
        padding: 0 5px;
    }

    select {
        width: auto;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #2386c7;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    /* Foto de perfil */
    .foto-de-perfil {
        width: 100%;
        display: flex;
        align-items: center;
        flex-direction: row;
        padding: 20px;
        padding-left: 56px;
    }

    .informacion-foto {
        width: auto;
        display: flex;
        flex-direction: column;
    }

    .usuario-nombre {
        display: flex;
        flex-direction: column;
        margin: 10px;
    }

    .usuario-info {
        width: 100%;
        display: flex;
        flex-direction: column;

    }

    #cambiarFotoInput {
        display: none;
    }

    #cargar {
        color: #657786;
        font-size: 0.8em;
        background-color: transparent;
        padding: 0;
        margin: 0;
        border-radius: 0;
        cursor: pointer;
        font-size: 10px;
        border: none;
    }

    #cargar:hover {
        color: black;
    }

    #formDatos {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;

    }

    .usuario-avatar {
        /*border: 2px solid darkgray;*/
        width: 150px;
        height: 150px;
        border-radius: 5%;
        overflow: hidden;
        position: relative;
        margin-right: 10px;
    }

    .usuario-avatar .avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .guardarCambios {
        width: auto;
        background-color: #2386c7;
        padding: 12px 40px;
        border: 1px solid grey;
        border-radius: 5px;
        font: 16px system-ui;
        color: #f2f2f2;
    }

    .guardarCambios:hover {
        background-color: #f2f2f2;
        color: #2386c7;
    }

    .guardarCambios:active {
        background-color: #333;
    }

    /**aside boton */
    .toggle {
        display: flex;
        justify-content: flex-end;
    }

    .toggle-menu {
        background-color: transparent;
        width: 20px;
        height: 20px;
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }

    .bar {
        width: 100%;
        height: 3px;
        background-color: #fff;
        margin: 1.5px 0;
        transition: transform 0.3s;
        box-sizing: border-box;
    }

    .toggle-menu.active .bar:nth-child(1) {
        transform: translateY(6px) rotate(45deg);
    }

    .toggle-menu.active .bar:nth-child(2) {
        opacity: 0;
    }

    .toggle-menu.active .bar:nth-child(3) {
        transform: translateY(-6px) rotate(-45deg);
    }

    /**aside */
    aside {
        background-color: rgba(0, 0, 0, 0.5);
        width: 300px;
        height: 100%;
        padding: 20px;
        display: block;
        position: relative;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);
        color: white;
        box-sizing: border-box;
        transition: left 0.3s;
        left: 0px;
        border-radius: 0;
        overflow: visible;
    }

    .contenedor {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 100%;
        height: 200px;
        perspective: 1000px;
        transition: left 0.9s;
        position: relative;
        padding-left: 10px;
    }

    .elemento {
        width: 90%;
        height: 30px;
        background-color: transparent;
        display: flex;
        justify-content: center;
        transition: transform 0.3s;
        transform-style: preserve-3d;
        transform-origin: left center;
    }

    .elemento:hover {
        transform: scaleX(1.1) scaleY(1.1);
        background-color: rgba(255, 255, 255, 0.5);
        background-color: #333;
        border-radius: 10px;
        backface-visibility: hidden;
    }

    .contenedor .elemento.active {
        background-color: #333;
        /* background-color: rgba(255, 255, 255, 0.5); */
        color: #fff;
        border-radius: 10px;
    }

    .elemento a {
        display: inline-block;
        width: 100%;
        height: 100%;
        padding: 3px 13px;
        font-size: 16px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-weight: 10;
        color: #f2f2f2;
        text-decoration: none;
        line-height: normal;
        box-sizing: border-box;
    }

    .elemento a:hover {
        text-decoration: none;
        color: #f2f2f2;
    }

    aside h2 {
        font-family: System-Ui;
        font-size: 16px;
    }

    #sidebar.hidden {
        left: -100%;
        display: none;
    }

    #sidebar.slide {
        left: 0;
    }


    /**mostrar errores */

    .mostrarErrores,
    .mostrarExito {
        width: 300px;
        height: 50px;
        border-radius: 5px;
        font-size: 13px;
        font-family: ui-monospace;
        font-weight: 500;
        margin: 0 auto;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mostrarErrores {
        border: 1px solid #ff000047;
        background-color: rgb(255 37 37 / 22%);
        color: #bb4040;
    }

    .mostrarExito {
        border: 1px solid #00ff0047;
        background-color: rgb(37 255 155 / 22%);
        color: #40bb42;
    }

    /**header*/


    /**footer */
    footer {
        grid-area: footer;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        text-align: center;
        color: white;
        font-family: System-Ui;
        background-color: transparent;

    }

    .footer-top {
        display: flex;
        flex-direction: row;
        justify-content: center;
        background-color: #657786;
        margin: 20px;
    }

    .footer-texto {
        width: 40%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-sizing: border-box;
        padding: 3%;
        text-shadow: 1px 2px 3px rgba(0, 0, 0, 0.5);
    }

    .footer-img {
        width: 40%;
        max-height: 300px;
        position: relative;
    }

    .footer-img img {
        width: 100%;
        height: 119%;
        object-fit: cover;
        filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.7));
    }

    .footer-principal {
        width: 100%;
        height: auto;
        background-color: #333;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        padding: 30px;
    }

    .principal-arriba {
        display: flex;
        flex-direction: row;
    }

    .arriba-texto {
        width: 50%;
    }

    .arriba-img {
        width: 50%;
        overflow: hidden;
    }

    .arriba-img img {
        width: 40%;
        height: auto;
    }

    .footer-final {
        background-color: #333;
        width: 100%;
        height: 100px;

    }

    .form-login fieldset {
        width: 100%;
    }

    .form-login button {
        background-color: transparent;
        border: none;
        cursor: pointer;

    }

    .form-login button img {
        width: 50px;
        height: auto;
    }

    .form-login button img:hover {
        transform: scale(1.2);
    }

    .form-login input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
        /*border-color: #fff;*/
        border-left: 0;
        border-top: 0;
        border-right: 0;
        background-color: transparent;
        outline: none;
    }


    @media (max-width: 768px) {
        html {
            padding: 0;
            margin: 0;
        }

        body {
            grid-template-columns: 1fr;
            grid-template-areas:
                "header"
                "main"
                "footer";
        }

        aside {
            background-color: rgba(0, 0, 0, 0.5);
            width: 25%;
            height: 100%;
            margin-top: 50px;
            padding: 20px;
            display: none;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);
            position: absolute;
            color: white;
            z-index: 1;
            left: -100%;
            transition: left 0.9s;
        }

        @media (max-width: 680px) {
            fieldset {
                flex-direction: column;
            }

            .footer-texto {
                width: 50%
            }
        }
    }
</style>
<script src="perfil.js">

    document.addEventListener('DOMContentLoaded', function () {
        const toggleMenu = document.querySelector('toggle-menu');
        const sidebar = document.getElementById('sidebar');

        toggleMenu.addEventListener('click', function () {
            //sidebar.classList.toggle('active');
            toggleMenu.classList.toggle('active');
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var url = window.location.href;

        document.querySelectorAll('.contenedor .elemento').forEach(function (link) {
            if (url.includes(link.getAttribute('href'))) {
                link.parentElement.classList.add('active');
            }
        });
    });



</script>

</html>