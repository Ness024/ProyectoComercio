<?php
include 'Layouts/header.php';
?>
<main>
    <section class="principal">
        <div id="resumen-container">
            <h2>Resumen de la Compra</h2>
            <div class="seccion">
                <h3>Información del Cliente</h3>
                <div class="detalle">
                    <strong>Nombre del Cliente:</strong>
                    <span id="nombre-cliente"></span>
                </div>
                <div class="detalle">
                    <strong>Dirección de Envío:</strong>
                    <span id="direccion"></span>
                </div>
            </div>

            <div class="seccion">
                <h3>Detalles de Pago</h3>
                <div class="detalle">
                    <strong>Método de Pago:</strong>
                    <span id="tipo-targeta"></span>
                </div>
                <div class="detalle">
                    <strong>Número de Tarjeta:</strong>
                    <span id="numero-targeta"></span>
                </div>
                <div class="detalle">
                    <strong>Fecha de Vencimiento:</strong>
                    <span id="vencimiento"></span>
                </div>
                <div class="detalle">
                    <strong>Titular de la Tarjeta:</strong>
                    <span id="titular"></span>
                </div>
            </div>
            <div class="seccion">
                <h3>Fecha de Entrega</h3>
                <div class="detalle">
                    <strong>Fecha Estimada:</strong>
                    <span id="entrega">15 de enero de 2024</span>
                </div>
            </div>

            <div class="seccion">
                <h3>Resumen del Pedido</h3>
                <div class="detalle">
                    <strong>Cantidad de Productos:</strong>
                    <span id="cantidad-productos"></span>
                </div>
                <div class="detalle">
                    <strong>Monto Total:</strong>
                    <span id="total-pagar"></span>
                </div>
            </div>

            <div class="seccion">
                <p>Revisa la información y confirma tu compra.</p>
                <a id="limpiar" href="#" class="boton-confirmar">Confirmar Compra</a>
            </div>
        </div>
    </section>
    <section class="carritoCompras">
        <div class="listadecompras">
            <h3>Carrito</h3>
            <ul id="productoCarrito"></ul>
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
    main {
        background-color: #f4f4f4;
        display: flex;
        flex-direction: row;
        padding: 0 40px;
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

    .principal {
        width: 100%;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    #resumen-container {
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        max-width: 600px;
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .seccion {
        margin-bottom: 20px;
    }

    .seccion h3 {
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
        color: #555;
        margin-bottom: 10px;
    }

    .detalle {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .detalle strong {
        color: #333;
    }

    .boton-confirmar {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        transition: background-color 0.3s;
    }

    .boton-confirmar:hover {
        background-color: #45a049;
    }
</style>
<script src="script.js"></script>
<script src="scripts/orden.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        verCarrito();
        verOrden();
    });
</script>

</body>

</html>