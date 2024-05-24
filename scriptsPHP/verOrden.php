<?php
session_start();
if ($_SESSION['correo']) {
    $usuario_id = $_SESSION['user_id'];
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require 'db_connection.php';
    $metodo = 'Tarjeta de Credito';
    try {
        $consulta_usuario_carrito = "SELECT
                                    MAX(u.nombre) as nombre, MAX(u.apellidos) as apellidos,
                                    MAX(d.direccion) as direccion, MAX(d.colonia) as colonia, MAX(d.ciudad) as ciudad, MAX(d.codigo_postal) as codigo_postal,
                                    MAX(t.apellido_titular) as apellido_titular, MAX(RIGHT(t.numero_tarjeta, 4)) as ultimos_digitos, MAX(t.fecha_expiracion) as fecha_expiracion,
                                    SUM(c.cantidad) as cantidad_total, SUM(c.cantidad * c.total) as total_pagar
                             FROM usuarios u
                             JOIN domicilios d ON u.id = d.usuario_id
                             JOIN tarjetas t ON u.id = t.usuario_id
                             JOIN carrito_compras c ON u.id = c.usuario_id
                             WHERE u.id = :usuario_id
                             GROUP BY u.id";

        $stmt_usuario_carrito = $conexion->prepare($consulta_usuario_carrito);
        $stmt_usuario_carrito->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt_usuario_carrito->execute();
        $detalles_usuario_carrito = $stmt_usuario_carrito->fetch(PDO::FETCH_ASSOC);
        $ing_pago = json_encode(array('ultimos_digitos' => $detalles_usuario_carrito['ultimos_digitos'], 'fecha_expiracion' => $detalles_usuario_carrito['fecha_expiracion']));

        $pedido_id = $conexion->lastInsertId();

        $pedido_info = array(
            'nombre' => $detalles_usuario_carrito['nombre'],
            'apellidos' => $detalles_usuario_carrito['apellidos'],
            'direccion' => $detalles_usuario_carrito['direccion'],
            'colonia' => $detalles_usuario_carrito['colonia'],
            'ciudad' => $detalles_usuario_carrito['ciudad'],
            'codigo_postal' => $detalles_usuario_carrito['codigo_postal'],
            'apellido_titular' => $detalles_usuario_carrito['apellido_titular'],
            'ultimos_digitos' => $detalles_usuario_carrito['ultimos_digitos'],
            'fecha_expiracion' => $detalles_usuario_carrito['fecha_expiracion'],
            'cantidad_total' => $detalles_usuario_carrito['cantidad_total'],
            'total_pagar' => $detalles_usuario_carrito['total_pagar'],
            'pedido_id' => $pedido_id,
        );

        header('Content-Type: application/json');
        echo json_encode([
            'error' => false,
            'mensaje' => 'Consulta exitosa',
            'orden' => $pedido_info
        ]);

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

//session_start();
//if ($_SESSION['correo']) {
//    $usuario_id = $_SESSION['user_id'];
//}
//if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//    require 'db_connection.php';
//    try {
//        $consulta = "SELECT u.nombre, u.apellidos,
//        MAX(d.direccion) as direccion, MAX(d.colonia) as colonia, MAX(d.ciudad) as ciudad, MAX(d.codigo_postal) as codigo_postal,
//        MAX(t.apellido_titular) as apellido_titular, MAX(RIGHT(t.numero_tarjeta, 4)) as ultimos_digitos, MAX(t.fecha_expiracion) as fecha_expiracion,
//        SUM(c.cantidad) as cantidad_total, SUM(c.cantidad * c.total) as total_pagar
//        FROM usuarios u
//        JOIN domicilios d ON u.id = d.usuario_id
//        JOIN tarjetas t ON u.id = t.usuario_id
//        JOIN carrito_compras c ON u.id = c.usuario_id
//        WHERE u.id = :usuario_id
//        GROUP BY u.id";
//        $stmt = $conexion->prepare($consulta);
//        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
//        $stmt->execute();
//        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
//        if ($resultado) {
//            header('Content-Type: application/json');
//            echo json_encode([
//                'error' => false,
//                'mensaje' => 'Consulta exitosa',
//                'orden' => $resultado
//            ]);
//        } else {
//            header('Content-Type: application/json');
//            echo json_encode(['error' => true, 'mensaje' => 'No se encontró Informacion']);
//        }
//    } catch (PDOException $e) {
//        header('Content-Type: application/json');
//        echo json_encode(['error' => true, 'mensaje' => 'Error en la base de datos: ' . $e->getMessage()]);
//    } finally {
//        if ($conexion) {
//            $conexion = null;
//        }
//    }
//} else {
//    header('Content-Type: application/json');
//    echo json_encode(['error' => true, 'mensaje' => 'Método no permitido']);
//}

?>