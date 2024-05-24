<?php
session_start();
if (isset($_SESSION['correo'])) {
    $usuarioId = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'limpiarCarrito') {
            limpiarCarrito($usuarioId);
        } elseif ($accion === 'eliminarProducto') {
            $productoId = $_POST['producto_id'];
            eliminarProductoDeCarrito($usuarioId, $productoId);
        } else {
            die('Fatal Error');
        }
    }
}

function limpiarCarrito($usuarioId)
{
    include 'db_connection.php';

    try {
        $sqlLimpiar = "DELETE FROM carrito_compras WHERE usuario_id = :id";
        $limpiarCarrito = $conexion->prepare($sqlLimpiar);
        $limpiarCarrito->bindParam(":id", $usuarioId);
        $limpiarCarrito->execute();
        //$filas_afectadas = $limpiarCarrito->rowCount();
    } catch (PDOException $e) {
        echo "Error al limpiar el carrito: " . $e->getMessage();
    } finally {
        $conexion = null;
    }
}

function eliminarProductoDeCarrito($usuarioId, $productoId)
{
    include 'db_connection.php';

    try {
        $sqlEliminar = "DELETE FROM carrito_compras WHERE usuario_id = :usuario_id AND producto_id = :producto_id";
        $eliminarProducto = $conexion->prepare($sqlEliminar);
        $eliminarProducto->bindParam(":usuario_id", $usuarioId);
        $eliminarProducto->bindParam(":producto_id", $productoId);
        $eliminarProducto->execute();
        $filas_afectadas = $eliminarProducto->rowCount();
        if ($filas_afectadas > 0) {
            header('Content-Type: application/json');
            echo json_encode(['error' => false, 'mensaje' => 'Producto eliminado']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => true, 'mensaje' => 'No se encontró el producto en el carrito']);
        }
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => true, 'mensaje' => 'Hubo un error: ' . $e->getMessage()]);
    } finally {
        $conexion = null;
    }




}
?>