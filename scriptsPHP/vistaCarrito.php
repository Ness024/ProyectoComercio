<?php

session_start();
if (!isset($_SESSION['correo'])) {
        header("Location: Iniciar_Sesion.php");
} else {
        $usuario = $_SESSION["correo"];
        $usuario_id = $_SESSION["user_id"];
}
include 'db_connection.php';

try {
        $sql = "SELECT p.*, c.cantidad, c.total 
            FROM carrito_compras c 
            INNER JOIN productos p 
            ON c.producto_id = p.id 
            WHERE c.usuario_id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $usuario_id);
        $stmt->execute();

        $carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($carrito) {
                header('Content-Type: application/json');
                echo json_encode($carrito);
        } else {
                echo json_encode(['mensaje' => 'No hay datos en el carrito']);
        }
} catch (PDOException $e) {
        echo json_encode(array('error' => 'Error de base de datos: ' . $e->getMessage()));
} finally {
        if ($conexion) {
                $conexion = null;
        }
}
?>