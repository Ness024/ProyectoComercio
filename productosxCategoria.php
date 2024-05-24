<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idCategoria=$_GET['id'];
    $nombre=$_GET['idnombre'];

    include 'db_connection.php';

    $sql="SELECT c.nombre AS categoria, p.id, p.nombre, p.descripcion, p.precio, p.stock, p.imagen, p.rate
    FROM productos p
    JOIN categorias c ON p.categoria_id = c.id
    WHERE c.id = :id
    ORDER BY p.id DESC;";
    /*LIMIT 20; ";*/
    $stmt=$conexion->prepare($sql);
    $stmt->bindParam(':id', $idCategoria, PDO::PARAM_STR);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

}else{
    header("Location: home.php");
}
 include 'Layouts/header.php';
?>
    <main>
        <div class="encabezadodeSeccion">
            <img src="Resources/<?php echo $nombre ?>.jpg" alt="">
            <h1><?php echo $nombre; ?></h1>
        </div>

        <article class="seccionProductos listadoproductosporseccion">
            <div>
                <div class="seccionProductos">
                    <section>
                </div>
                <ul class="listadoProductos">
                <?php if ($productos) {
                        foreach ($productos as $producto) {
                            ?>
                    <li class="contenedor-producto" data-product-id="1">
                        <a href="Producto.php?id=<?php echo $producto['id']; ?>"><img src="<?php echo $producto['imagen']; ?>" alt=""></a>
                        <button class="botonFavoritos" onclick="toggleActive(1)"></button>
                        <a href="Producto.php?id=<?php echo $producto['id']; ?>" class="anchorTitulo"> <?php echo $producto['nombre']; ?></a>
                        <p><?php echo $producto['descripcion']; ?></p>
                        <span class="inlineCarrito">
                            <p class="precio">$ <?php echo $producto['precio']; ?></p>
                            <button onclick="agregarAlCarrito(<?= $producto['id'] ?>)">
                                <img class="carritoImg" src="Resources/MdiCartPlus.svg" alt="">
                            </button>
                        </span>
                    </li>
                    <?php }
                    } else { ?>
                        <li><p>No hay productos de esta categoria</p></li>
                    <?php } ?>

                </ul>
            </div>

        </article>
    </main>
    <script src="script.js"></script>
</body>
</html>
