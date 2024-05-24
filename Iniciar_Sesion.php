
<?php
session_start();
if (isset($_SESSION["correo"])) {
    header('Location: perfilDeUsuario.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
</head>

<body>
    <header>
        <nav>
        </nav>
    </header>
    <main class="mainflex">
        <div class="contenedor">
            <div class="imagen-contenedor">
                <img src="Resources/gatologo.png" alt="">
                <h1 class="titulologin">GatitoDeveloper</h1>
            </div>
            <div class="formulario">
                <form action="scriptsPHP/procesar_login.php" method="post" class="form">
                    <h4>¡Hola!, somos GatitoDeveloper</h4>
                    <p>Inicia sesion con tu correo</p>
                    <fieldset>
                        <legend>Datos Personales</legend>
                        <div class="form-group">
                            <label>
                                <span>Correo electrónico</span>
                                <input type="email" autocomplete="" id="email" name="email" required>
                            </label>

                        </div>
                        <div class="form-group">
                            <label>
                                <span>Contraseña</span>
                                <input type="password" autocomplete="" id="password" name="password" required>
                            </label>
                        </div>
                    </fieldset>
                    <div class="botones">
                        <input type="submit" value="Iniciar sesión">
                    </div>
                </form>
                <p>¿Eres nuevo en GatitoDeveloper?</p>
                <div class="botones2">
                    <a href="Registrarse.html">Crea tu cuenta</a>
                </div>
            </div>

        </div>
    </main>
    <footer>
        <section>
            <h4>Contactanos</h4>
        </section>
        <section>
            <h5>Dirección</h5>
            <p>PetTopía S.A. de C.V.</p>
            <p>Calle de las Mascotas #123</p>
            <p>Colonia Animalia</p>
            <p>Ciudad Petville, CP 12345</p>
            <p>País de las Mascotas</p>
            <h5>Número de Teléfono:</h5>
            <a href="tel:+1 (555) 123-456">+1 (555) 123-456</a>
        </section>
        <section>
            <h5>Correo Electrónico de Soporte:</h5>
            <a href="mailto:support@pettopia.com">support@pettopia.com</a>
            <h5>Horario de Atención al Cliente:</h5>
            <p>Lunes a Viernes: 9:00 a.m. - 6:00 p.m.</p>
            <p>Sábado: 10:00 a.m. - 2:00 p.m. (Hora local de Petville)</p>
        </section>
        <section>
            <h5>Redes Sociales:</h5>
            <p>Facebook: <a target="_blank" href="">facebook.com/pettopia</a></p>
            <p>Instagram: @pettopia_official</p>
            <p>Twitter: @PetTopia_tweets</p>
        </section>
    </footer>
</body>
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;

    }


    .mainflex,.mainflex > div {
        display: flex;
        align-items: center;
    }
    .mainflex {
        min-height: 99vh;
        justify-content: center;
    }


    .mainflex > div { 
        justify-content: space-between; 
        width: 80%;
        max-width: 1000px;
    }

    .mainflex img {
        width: 100%;
        max-width: 400px;
    }
    .titulologin {
        color: black;
        text-align: center;
        margin: 0;
        font-size: 2.5em;
    }

    .contenedor {
        display: flex;
        max-width: 100%;
        margin: 20px auto;
        align-items: flex-start;
    }

    .form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-right: 20px;
        width: 300px;
        box-sizing: border-box;
    }

    .form-group {
        margin-bottom: 5px;
        padding-top: 10px;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    fieldset {
        border: transparent;
        padding: 0;
        margin-bottom: 10px;
    }

    legend {
        display: none;
    }

    span,
    input {
        font: 16px/16px Verdana;
        padding: 0;
    }

    label {
        display: block;
        width: 100%;
        border: 1px solid silver;
        padding: 8px 10px;
        position: relative;
        box-sizing: border-box;
        border-radius: 4px;
        transition: .25s;

    }

    label input {
        display: block;
        width: 100%;
        border: none;
        background: transparent;
        outline: none;

    }

    label.focus {
        border-color: #2386c7;
    }

    label span.focus {
        color: #2386c7;
    }

    label span.top {
        left: 2px;
        top: -10px;
        font-size: 12px;
        background: white;
        padding: 0 5px;
    }

    label span {
        position: absolute;
        color: silver;
        top: 8px;
        left: 10px;
        transition: .25s;
    }


    .botones {
        width: 100%;
        box-sizing: border-box;
    }

    input[type="submit"],
    .botones2 a {
        width: 100%;
        background-color: #3498db;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .botones input[type="submit"]:hover {
        background-color: #236fa1;
        color: #fff;
    }

    .botones2 {
        text-align: center;
        padding: 0px 40px 0px 20px;
    }

    .botones2 a {
        background-color: transparent;
        border: 1px solid #3498db;
        color: #3498db;
        text-decoration: none;
    }

    .botones2 a:hover {
        background-color: #3498db;
        color: #fff;
    }

    .formulario p {
        margin-top: 15px;
        text-align: center;
    }

    .imagen-contenedor {
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
    }

    img {
        max-width: 35%;
        height: auto;
        border-radius: 10px;
        /*box-shadow: -20px -16px 9px 14px rgb(0 0 0 / 10%);*/
    }

    section {
        width: 48%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    footer {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-template-rows: auto 1fr;
        align-items: start;
        justify-items: center;
        background: #0d192e;
        padding: 20px 40px;
        color: white;
        height: fit-content;
    }

    footer section:first-child {
        grid-row-start: span 1;
        grid-column-start: span 3;
    }

    footer a {
        color: white;
    }
    footer a:hover {
        color: aquamarine;
    }
   

    @media (max-width: 1200px) and (min-width: 681px){
        .titulologin {
            font-size: x-large;
        }
    }

    @media (max-width: 680px) {
        .mainflex > div {
            flex-direction: column;
        }
        .imagen-contenedor img {
                display: none;
            }
        
    }

    
    @media (max-width: 1200px) and (min-width: 681px){
        .titulologin {
            font-size: x-large;
        }
    }

    @media (max-width: 680px) {
        footer {
            width: 90%;
            display: flex;
            flex-direction: column;
        }
        section {
            width: 100%;
        }
    }
</style>

<script>
    const anima = document.querySelectorAll('input');
    anima.forEach(input => {
        input.onfocus = () => {
            input.previousElementSibling.classList.add('top')
            input.previousElementSibling.classList.add('focus')
            input.parentNode.classList.add('focus')
        }
        input.onblur = () => {
            input.value = input.value.trim();
            if (input.value.trim().length == 0) {
                input.previousElementSibling.classList.remove('top')
            }
            input.previousElementSibling.classList.remove('focus')
            input.parentNode.classList.remove('focus')

        }
    });
</script>

</html>