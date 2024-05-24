<?php
require 'Layouts/header.php';
?>
    <main>
        <section class="contenedor-externo">
            <div class="botones-container">
                <button class="boton-desplazar boton-izquierda" onclick="desplazar(-1)">◄</button>
                <button class="boton-desplazar boton-derecha" onclick="desplazar(1)">►</button>
            </div>
            <div class="carrusel" id="carrusel">
                <div class="elementos">
                    <img src="Resources/CarruselImgs.png" alt="">
                </div>
                <div class="elementos">
                    <img src="Resources/CarruselImgs2.png" alt="">
                </div>
                <div class="elementos">
                    <img src="Resources/CarruselImgs3.png" alt="">
                </div>
                <div class="elementos">
                    <img src="Resources/CarruselImgs4.png" alt="">
                </div>
                <div class="elementos">
                    <img src="Resources/CarruselImgs5.png" alt="">
                </div>
            </div>
        </section>
        <section class="divisionProductos">
            <aside>
                <?php
                include 'db_connection.php';
                $consultarCategorias = "SELECT * FROM categorias
                                        ORDER BY id DESC
                                        LIMIT 20;";
                $stmt1 = $conexion->prepare($consultarCategorias);
                $stmt1->execute();
                $categorias = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <h3>Catergorias</h3>
                <ul>
                    <?php
                    if ($categorias) {
                        foreach ($categorias as $categoria) {
                            ?>
                            <li><a href="productosxCategoria.php?id=<?php echo $categoria['id']; ?>&idnombre=<?php echo $categoria['nombre']; ?>">
                                    <?php echo $categoria['nombre']; ?>
                                </a>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </aside>

            <article class="seccionProductos">
                <?php
                include 'db_connection.php';
                $sql = "SELECT * FROM productos
                      ORDER BY rate DESC
                      LIMIT 60;";
                $stmt = $conexion->prepare($sql);
                $stmt->execute();
                $masVendidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div>
                    <div class="seccionProductos">
                        <section>
                            <div class="generosEncabezado">
                                <h4>Mas vendidos</h4>
                                <a href="">Ver mas <strong>></strong></a>
                            </div>
                    </div>
                    <ul class="listadoProductos">
                        <?php ?>
                        <?php if ($masVendidos) {
                            foreach ($masVendidos as $vendido) { ?>
                                <li>
                                    <article class="contenedor-producto" data-product-id="<?php echo $vendido['id']; ?> ">
                                        <a href="Producto.php?id=<?php echo $vendido['id']; ?>" ><img src="<?php echo $vendido['imagen']; ?>" alt=""></a>
                                        <button class="botonFavoritos" onclick="toggleActive(1)"></button>
                                        <a href="Producto.php?id='<?php echo $vendido['id']; ?>" class="anchorTitulo">
                                            <?php echo $vendido['nombre']; ?>
                                        </a>
                                        <p>
                                            <?php echo $vendido['descripcion']; ?>
                                        </p>
                                        <span class="inlineCarrito">
                                            <p class="precio">
                                                <?php echo "$" . $vendido['precio']; ?>
                                            </p>
                                            <button onclick="agregarAlCarrito(<?= $vendido['id'] ?>)">
                                                <img class="carritoImg" src="Resources/MdiCartPlus.svg" alt="">
                                            </button>
                                        </span>
                                        
                                    </article>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>

            </article>
        </section>
        <script src="script.js"></script>
        <script src="carrusel_animado.js"></script>

    </main>
<style>
    aside {
    box-sizing: border-box;
    width: 30%;
    border: solid .1em #575757;
    border-radius: 10px;
    margin-right: 10px;
    padding: 10px;
    height: fit-content;
}

ul {
    padding: 0;
}
li {
    list-style: none;
}

aside li {
    margin-top: 10px;
}
aside a {
    color: #727070;
    font-weight: 500;
    transition: ease-out .2s ;
}

aside a:hover {
    text-decoration: underline;
    color: #FF4147;
}
</style>
</body>

</html>

