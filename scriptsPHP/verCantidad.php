<?php
    session_start();
    if (isset($_SESSION['correo'])) {
        $usuario_id=$_SESSION['user_id'];
    }
    
    try{
        include 'db_connection.php';
        
        $sql_cantidad = "SELECT SUM(cantidad) AS cantidad_total
                        FROM carrito_compras WHERE usuario_id  = :id;";
        $stmt_cantidad = $conexion->prepare($sql_cantidad);
        $stmt_cantidad->bindParam(':id',$usuario_id);
        $stmt_cantidad->execute();
        $cantidad = $stmt_cantidad->fetch(PDO::FETCH_ASSOC);
        if ($cantidad) {
            header('Content-Type: application/json');
            echo json_encode([
                'error' => false,
                'mensaje' => 'Consulta exitosa',
                'cantidad' => $cantidad
            ]);
        } 
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => true, 'mensaje' => 'Error en la base de datos: ' . $e->getMessage()]);
    } finally {
        if ($conexion) {
            $conexion = null;
        }
    }
?>