<?php
$resultados = isset($_GET['resultados']) ? json_decode($_GET['resultados'], true) : [];

include 'Layouts/header.php';
?>
    <main>
        <article class="seccionProductos listadoproductosporseccion">
            <div>
                <div class="seccionProductos">
                    <section>
                </div>
                <?php if ($resultados) { ?>
                <ul class="listadoProductos">
                    <?php foreach ($resultados as $resultado) {
                            ?>
                    <li class="contenedor-producto" data-product-id="1">
                        <a href="Producto.php?id=<?php echo $resultado['id']; ?>"><img src="<?php echo $resultado['imagen']; ?>" alt=""></a>
                        <button class="botonFavoritos" onclick="toggleActive(1)"></button>
                        <a href="producto.php?id=<?php echo $resultado['id']; ?>" class="anchorTitulo"> <?php echo $resultado['nombre']; ?></a>
                        <div class="aparecera"><p><?php echo $resultado['nombre']; ?></p></div>
                        <p><?php echo $resultado['descripcion']; ?></p>
                        <span class="inlineCarrito">
                            <p class="precio">$ <?php echo $resultado['precio']; ?></p>
                            <button onclick="agregarAlCarrito(<?= $resultado['id'] ?>)">
                                <img class="carritoImg" src="Resources/MdiCartPlus.svg" alt="">
                            </button>
                        </span>
                    </li>
                    <?php } ?>
                </ul>
                <?php } else { ?>
                    <li class="no-encontrado"><p>No se encontraron Productos</p></li>
                <?php } ?>
            </div>

        </article>
    </main>
    <script src="script.js"></script>
</body>
<style>
    
    .no-encontrado{
    width:100%;
    margin: 50px;
    padding: 50px;
    text-align: center;
    font: bold 20px System-Ui;
    
}


.contenedor-producto{
    position: relative;
}
.aparecera{
    display: none;
    position: fixed;
    width: auto;
    background-color: white;
    width: auto;
    font-size: 12px;
    padding: 3px;
    border: 1px solid black;
}

.contenedor-producto:hover .aparecera{
    display: block;
}




/*.contenedor-producto:hover{
    overflow: visible;
}

.anchorTitulo:hover {
    position: sticky;
    top: 0px;
    width:200%;
}
  */                
    </style>
</html>
