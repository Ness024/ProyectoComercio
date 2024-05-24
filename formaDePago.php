<?php
include 'Layouts/header.php';
?>
<main>
    <section style="width: 100%; text-align: center;">
        <form action="" method="post" class="form-pago" id="formPago">
            <h3>Información de la tarjeta de crédito/débito</h3>
            <fieldset>
                <label for="nombre">Nombre</label>
                <label for="nombre" class="nombres">
                    <input type="text" placeholder="Primer nombre" required autocomplete="cc-given-name" name="nombre"
                        id="nombre" />
                    <input type="text" placeholder="Segundo nombre" autocomplete="cc-given-name" name="segundo-nombre"
                        id="segundo-nombre" />
                </label>
                <label for="titular">Apellido</label>
                <input type="text" placeholder="Apellido titular" required autocomplete="cc-family-name" name="titular"
                    id="titular" />
                <label for="numerodetarjeta">Número de tarjeta de crédito/débito.</label>
                <input type="text" pattern="[0-9]*" maxlength="16" placeholder="Número de tarjeta" required
                    autocomplete="cc-number" name="numerodetarjeta" id="numerodetarjeta" />
                <label for="fecha" class="datostarjetas">
                    <input type="text" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" placeholder="Fecha (MM/YY)" required
                        autocomplete="cc-exp" name="fecha" id="fecha" />
                    <input type="text" pattern="[0-9]{3,4}" maxlength="4" placeholder="CVV" required
                        autocomplete="cc-csc" name="cvv" id="cvv" />
                </label>
            </fieldset>
            <button class="pagar" id="botonPago">Guardar Cambios</button>
        </form>
        <button class="pagar" id="limpiar">Cotinuar con la compra</button>
        <div id="mostrarErrores"></div>
    </section>
    <section class="carritoCompras">
        <div class="listadecompras">
            <h3>Carrito</h3>
            <ul id="productoCarrito"></ul>
            <button onclick="limpiarCarrito() " class="limp">Limpiar Carrito</button>
        </div>
        <div class="previewTotal">
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
    main {
        display: flex;
        flex-direction: row;
        padding: 0 20px;
    }

    .form-pago {
        width: 80%;
        max-width: 950px;
        padding: 0% 5%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .carritoCompras {
        display: flex;
        flex-direction: column-reverse;
        width: 80%;
        max-width: 400px;
    }

    .previewTotal {
        width: 100%;
    }

    .listadecompras {
        width: 100%;
    }

    .limp,
    #limp {
        display: none;
    }
</style>
<script src="script.js"></script>
<script src="scripts/verTargeta.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        verCarrito();
        verPago();
    });

document.getElementById("limpiar").addEventListener("click", function (event) {
    redirigir();
});

function redirigir() {
    fetch("scriptsPHP/redirigir_a_Orden.php", {
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