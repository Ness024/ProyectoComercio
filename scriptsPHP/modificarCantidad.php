<?php

session_start();
if (isset($_SESSION['correo'])) {
    $usuario_id=$_SESSION['user_id'];
}

include 'db_connection.php';

$producto_id = $_GET['producto_id'];
$cantidad = $_GET['cantidad'];

/*
if (!is_numeric($usuario_id) || !is_numeric($producto_id) || !is_numeric($cantidad)) {
    header("HTTP/1.1 400 Bad Request");
    echo "Los parámetros deben ser numéricos.";
    exit();
}
*/

$sql_precio = "SELECT precio FROM productos WHERE id = :id";
$stmt_precio = $conexion->prepare($sql_precio);
$stmt_precio->bindParam(':id', $producto_id);
$stmt_precio->execute();
$precio = $stmt_precio->fetchColumn();

//**************************** */

$sql_carrito = "SELECT cantidad 
                FROM carrito_compras 
                WHERE producto_id = :id 
                AND usuario_id = :usuario";
$stmt_carrito = $conexion->prepare($sql_carrito);
$stmt_carrito->bindParam(':id', $producto_id);
$stmt_carrito->bindParam(':usuario', $usuario_id);
$stmt_carrito->execute();
$cantidad_existente = $stmt_carrito->fetchColumn();


$cantidad_nueva = $cantidad_existente + $cantidad;
    $total_nuevo = $precio * $cantidad_nueva;

    $sql_actualizar = "UPDATE carrito_compras 
                       SET cantidad = :cantidad, total = :total 
                       WHERE producto_id = :id 
                       AND usuario_id = :usuario";
    $stmt_actualizar = $conexion->prepare($sql_actualizar);
    $stmt_actualizar->bindParam(':id', $producto_id);
    $stmt_actualizar->bindParam(':usuario', $usuario_id);
    $stmt_actualizar->bindParam(':cantidad', $cantidad_nueva);
    $stmt_actualizar->bindParam(':total', $total_nuevo);
    $stmt_actualizar->execute();
/*

$sql = "UPDATE carrito_compras 
        SET cantidad = cantidad + $cantidad 
        WHERE usuario_id = $usuario_id 
        AND producto_id = $producto_id";
$conn->query($sql);

*/ 
$conexion=null;

?>