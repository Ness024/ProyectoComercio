<?php
session_start();

if ($_SESSION['correo']) {
    $usuario_id = $_SESSION['user_id'];
    $ultimo_id_orden = $_SESSION['ultimo_id_orden'];

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db_connection.php';
    try {
        $obtenerDetalles = "SELECT IDProducto, Cantidad FROM DetallesOrden WHERE IDOrden = :ultimo_id_orden";
        $stmt = $conexion->prepare($obtenerDetalles);
        $stmt->bindParam(':ultimo_id_orden', $ultimo_id_orden, PDO::PARAM_INT);
        $stmt->execute();
        $ordenD = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        

        foreach ($ordenD as $detalles) {
            $idProducto = $detalles['IDProducto'];
            $cantidad = $detalles['Cantidad'];

            $sqlUpdate = "UPDATE Productos SET Stock = Stock - :cantidad WHERE id = :idProducto";
            $updateStock = $conexion->prepare($sqlUpdate);
            $updateStock->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $updateStock->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
            $updateStock->execute();
        }

        /*$sqlEstado = "UPDATE ordenes SET EstadoOrden = 'Pagado' WHERE id = :pedido_id";
        $actualizarEstado = $conexion->prepare($sqlEstado);
        $actualizarEstado->bindParam(':pedido_id', $ultimo_id_orden, PDO::PARAM_INT);
        $actualizarEstado->execute();
*/
header('Content-Type: application/json');
echo json_encode(['error' => false, 'mensaje' => 'exito ' ]);

    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => true, 'mensaje' => 'Error en la base de datos: ' . $e->getMessage()]);
    } finally {
        if ($conexion) {
            $conexion = null;
        }
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => true, 'mensaje' => 'Método no permitido']);
}
?>