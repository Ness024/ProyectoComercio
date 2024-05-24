<?php
 include 'Layouts/header.php';
?>
    <main>
        <section class="carritoCompras">
            <div class="listadecompras">
                <h3> Carrito</h3>
                <ul id="productoCarrito"></ul>
                <button onclick="limpiarCarrito()" id="limpiar">Limpiar Carrito</button>
                <div id="mostrarErrores">
                </div>
            </div>

            <div class="previewTotal">
                <p>Sub total:</p>
                <ul id="subtotal"></ul>
                <div class="total" style="display: flex; justify-content: space-between;">
                    <p>Total:</p>
                    <p><span id="total-carrito">0.00</span></p>
                </div>
                <center><button id="limpiar" onclick="hacerCompra()">Continuar con la compra</button></center>
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
    </style>
    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            verCarrito();
        });

        function hacerCompra(){
            window.location.href = 'domicilio.php';
        }
    </script>
</body>
</html>