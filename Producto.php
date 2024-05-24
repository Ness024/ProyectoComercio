<?php

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idProducto=$_GET['id'];

    include 'db_connection.php';

    $sql="SELECT * FROM productos WHERE id=:idProducto";
    $stmt=$conexion->prepare($sql);
    $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_STR);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

}else{
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Producto</title>
</head>
<body>
    <header>
        <div>
            <a href=""><img src="Resources/BiYelp.svg"></img></a>
            <h1>
                <a href="">Nombre <span>de la tienda</span></a>
            </h1>
        </div>

        <form action="">
            <input type="text"/>
            <button></button>
        </form>
        <div>
            <a href="">
            <img src="Resources/IconamoonProfileFill.svg" alt="" style="margin-right: 40px;"> 
            </a>
            <a href=""><span class="carritodeCompras">
                <p id="carritoCont">1</p>
                <img src="Resources/SolarCartLargeMinimalisticBold.svg" alt="">
                </span>
            </a>
        </div>
    </header>
    <main>
       <section class="detallesproducto">
            <div class="masInformacion">
                <article class="imgdprdocuto"><img src="<?php echo $producto['imagen']; ?>" alt=""></article>
                <span style="display: block;">
                    <h3> <?php echo $producto['nombre'] ?> </h3>
                    <p><?php echo $producto['descripcion'] ?></p>
                </span>
            </div>
            <div class="cantidadproductitos">
                <p>Precio: <?php echo $producto['precio'] ?> </p>
                <p>Cantidad: <?php echo $producto['stock'] ?> </p>
            </div>
       </section>
       <section class="masdetalles">
            <p>Mas detalles</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id deserunt illum omnis quos, et accusamus vitae libero veritatis quam voluptates obcaecati fuga incidunt, esse exercitationem at odit minus, totam tempore.</p>
       </section>
    </main>
</body>
</html>
