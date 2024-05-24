<?php
session_start();
if (isset($_SESSION['correo'])) {
    $usuario_id=$_SESSION['user_id'];
}
$producto_id = $_POST['producto_id'];

include 'db_connection.php';

$sql_precio = "SELECT precio FROM productos WHERE id = :id";
$stmt_precio = $conexion->prepare($sql_precio);
$stmt_precio->bindParam(':id', $producto_id);
$stmt_precio->execute();
$precio = $stmt_precio->fetchColumn();

$sql_carrito = "SELECT cantidad 
                FROM carrito_compras 
                WHERE producto_id = :id 
                AND usuario_id = :usuario";
$stmt_carrito = $conexion->prepare($sql_carrito);
$stmt_carrito->bindParam(':id', $producto_id);
$stmt_carrito->bindParam(':usuario', $usuario_id);
$stmt_carrito->execute();
$cantidad_existente = $stmt_carrito->fetchColumn();

if ($cantidad_existente) {
    $cantidad_nueva = $cantidad_existente + 1;
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
} else {
    $sql_insertar = "INSERT INTO carrito_compras (producto_id, usuario_id, cantidad, total) 
                    VALUES (:id, :usuario, 1, :precio)";
    $stmt_insertar = $conexion->prepare($sql_insertar);
    $stmt_insertar->bindParam(':id', $producto_id);
    $stmt_insertar->bindParam(':usuario', $usuario_id);
    $stmt_insertar->bindParam(':precio', $precio);
    $stmt_insertar->execute();
}

$conexion = null;
?>