<?php
include 'Layouts/header.php';
?>
<main class="domicilio">
    <div style="width: 100%; text-align: center;">
        <form action="" method="post" class="form-pago" id="formDomicilio">
            <h3>Direccion</h3>
            <fieldset>
                <label for="pnombre">Nombre</label>
                <input type="text" name="nombre" id="pnombre" placeholder="Ingrese su nombre">

                <label for="papellido">Apellido</label>
                <input type="text" name="apellido" id="papellido" placeholder="Ingrese su apellido">

                <label for="telefono">Teléfono</label>
                <input type="tel" name="telefono" id="telefono" placeholder="Ingrese su número de teléfono">

                <label for="calle">Calle</label>
                <input type="text" name="calle" id="pcalle" placeholder="Ingrese su calle">

                <label for="colonia">Colonia</label>
                <input type="text" name="colonia" id="pcolonia" placeholder="Ingrese su colonia">

                <label for="ciudad">Ciudad</label>
                <input type="text" name="ciudad" id="pciudad" placeholder="Ingrese su ciudad">
                <label for="cp" class="mas-info-direccion">
                    <input type="text" name="cp" pattern="[0-9]{5}" id="pcp" placeholder="Codigo Postal">
                    <input type="text" name="numE" id="nExterior" placeholder="Número exterior">
                    <input type="text" name="numI" id="nInterior" placeholder="Número interior">
                </label>

                <label for="referencias">Referencias</label>
                <textarea name="referencias" id="referencias" cols="30" rows="4"
                    placeholder="Ingrese cualquier referencia para la entrega"></textarea>
            </fieldset>

            <button class="pagar" id="botonDomicilio">Guardar Cambios</button>
        </form>
        <button class="pagar" id="limpiar">Cotinuar con la compra</button>
        <div id="mostrarErrores"></div>
    </div>

    <section class="carritoCompras previewcarrito">
        <div class="listadecompras">
            <h3>Carrito</h3>
            <ul id="productoCarrito"></ul>
            <button onclick="limpiarCarrito()" class="limp">Limpiar Carrito</button>

        </div>

        <div class="previewTotal width">
            <p>Sub total:</p>
            <ul id="subtotal"></ul>
            <div class="total" style="display: flex; justify-content: space-between;">
                <p>Total:</p>
                <p><span id="total-carrito">0.00</span></p>
            </div>
        </div>
    </section>
</main>
<link rel="stylesheet" href="estilosPasarela.css">
<style>
    .mostrarErrores,
    .mostrarExito {
        width: 300px;
        height: 50px;
        border-radius: 5px;
        font-size: 13px;
        font-family: ui-monospace;
        font-weight: 500;
        margin: 0 auto;
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

    /*nuevo edit*/
</style>
<script src="script.js"></script>
<script src="scripts/verDomicilio.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        verCarrito();
        verDireccion();
    });
</script>
<script>

    document.getElementById("limpiar").addEventListener("click", function (event) {
        redirigir();
    });

    function redirigir() {
        fetch("scriptsPHP/redirigir_a_formaPago.php", {
            method: "POST",
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                const mostrarError = document.getElementById("mostrarErrores");
                mostrarError.style.display = "flex";
                if (data.error) {
                    mostrarError.innerHTML = data.mensaje;
                    mostrarError.className = "mostrarErrores";
                } else {
                    if (data.redireccionar) {
                        window.location.href = data.redireccionar;
                    }
                }
                setTimeout(() => {
                    mostrarError.style.display = "none";
                }, 2000);
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }
</script>

</body>

</html>