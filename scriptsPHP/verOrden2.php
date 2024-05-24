<?php

session_start();
if ($_SESSION['correo']) {
    $userID = $_SESSION['user_id'];
}

require 'db_connection.php';

try {
    $conexion->beginTransaction();
    $sqlGetLastAddress = "SELECT id FROM domicilios WHERE usuario_id = :userID ORDER BY id DESC LIMIT 1";
    $stmtGetLastAddress = $conexion->prepare($sqlGetLastAddress);
    $stmtGetLastAddress->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmtGetLastAddress->execute();
    $lastAddress = $stmtGetLastAddress->fetch(PDO::FETCH_ASSOC);

    if ($lastAddress) {
        $direccionID = $lastAddress['id'];
    } else {
        echo "Error: El usuario no tiene ninguna dirección registrada.";
        exit;
    }

    $sqlGetLastCard = "SELECT id FROM tarjetas WHERE usuario_id = :userID ORDER BY id DESC LIMIT 1";
    $stmtGetLastCard = $conexion->prepare($sqlGetLastCard);
    $stmtGetLastCard->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmtGetLastCard->execute();
    $lastCard = $stmtGetLastCard->fetch(PDO::FETCH_ASSOC);

    if ($lastCard) {
        $metodoPagoID = $lastCard['id'];
    } else {
        echo "Error: El usuario no tiene ninguna tarjeta registrada.";
        exit;
    }
    $sqlGetCartTotal = "SELECT SUM(total) AS cartTotal FROM carrito_compras WHERE usuario_id = :userID";
    $stmtGetCartTotal = $conexion->prepare($sqlGetCartTotal);
    $stmtGetCartTotal->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmtGetCartTotal->execute();
    $cartTotal = $stmtGetCartTotal->fetch(PDO::FETCH_ASSOC);

    if ($cartTotal && isset($cartTotal['cartTotal'])) {
        $total = $cartTotal['cartTotal'];
    } else {
        echo "Error: El carrito está vacío.";
        exit;
    }

    $sqlOrden = "INSERT INTO Ordenes (IDUsuario, IDDireccion, IDMetodoPago, Total, EstadoOrden)
                      VALUES (:userID, :direccionID, :metodoPagoID, :total, 'pendiente')";

    $insertarOrden = $conexion->prepare($sqlOrden);
    $insertarOrden->bindParam(':userID', $userID, PDO::PARAM_INT);
    $insertarOrden->bindParam(':direccionID', $direccionID, PDO::PARAM_INT);
    $insertarOrden->bindParam(':metodoPagoID', $metodoPagoID, PDO::PARAM_INT);
    $insertarOrden->bindParam(':total', $total, PDO::PARAM_STR);

    if ($insertarOrden->execute()) {
        $ultimaOrden = $conexion->lastInsertId();
        $_SESSION['ultimo_id_orden'] = $ultimaOrden;
        $sqlOrdenDetalles = "INSERT INTO DetallesOrden (IDOrden, IDProducto, Cantidad, Precio)
                                  SELECT :ultimaOrden, producto_id, cantidad, total
                                  FROM carrito_compras
                                  WHERE usuario_id = :userID";
        $insertarOrdenDetalles = $conexion->prepare($sqlOrdenDetalles);
        $insertarOrdenDetalles->bindParam(':ultimaOrden', $ultimaOrden, PDO::PARAM_INT);
        $insertarOrdenDetalles->bindParam(':userID', $userID, PDO::PARAM_INT);


        if ($insertarOrdenDetalles->execute()) {
            $sqlBorrarCarrito = "DELETE FROM carrito_compras WHERE usuario_id = :userID";
            $borrarCarrito = $conexion->prepare($sqlBorrarCarrito);
            $borrarCarrito->bindParam(':userID', $userID, PDO::PARAM_INT);

            if ($borrarCarrito->execute()) {
                $conexion->commit();
                $cons_cart = "SELECT
                MAX(u.nombre) as nombre, MAX(u.apellidos) as apellidos,
                MAX(d.direccion) as direccion, MAX(d.colonia) as colonia, MAX(d.ciudad) as ciudad, MAX(d.codigo_postal) as codigo_postal,
                MAX(t.apellido_titular) as apellido_titular, MAX(RIGHT(t.numero_tarjeta, 4)) as ultimos_digitos, MAX(t.fecha_expiracion) as fecha_expiracion,
                SUM(c.cantidad) as cantidad_total, SUM(c.precio) as total_pagar
            FROM
                usuarios u
                JOIN domicilios d ON u.id = d.usuario_id
                JOIN tarjetas t ON u.id = t.usuario_id
                JOIN Ordenes o ON u.id = o.IDUsuario
                JOIN DetallesOrden c ON o.IDOrden = c.IDOrden
            WHERE
                u.id = :usuario_id
                AND o.IDOrden = (SELECT MAX(IDOrden) FROM Ordenes WHERE IDUsuario = :usuario_id)
            GROUP BY
                u.id";

                $stmt_usuario_carrito = $conexion->prepare($cons_cart);
                $stmt_usuario_carrito->bindParam(':usuario_id', $userID, PDO::PARAM_INT);
                $stmt_usuario_carrito->execute();
                $detalles_usuario_carrito = $stmt_usuario_carrito->fetch(PDO::FETCH_ASSOC);
                //$ing_pago = json_encode(array('ultimos_digitos' => $detalles_usuario_carrito['ultimos_digitos'], 'fecha_expiracion' => $detalles_usuario_carrito['fecha_expiracion']));

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
                );

                header('Content-Type: application/json');
                echo json_encode([
                    'error' => false,
                    'mensaje' => 'Consulta exitosa',
                    'orden' => $pedido_info
                ]);
            } else {
                $conexion->rollBack();
                header('Content-Type: application/json');
                echo json_encode(['error' => true, 'mensaje' => 'Error al limpiar el carrito. ' . $e->getMessage()]);
            }
        } else {
            $conexion->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['error' => true, 'mensaje' => 'Error al mover productos a DetallesOrden ' . $e->getMessage()]);
        }
    } else {
        $conexion->rollBack();

        header('Content-Type: application/json');
        echo json_encode(['error' => true, 'mensaje' => 'Error al insertar la orden ' . $e->getMessage()]);
    }
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => true, 'mensaje' => 'Error en la base de datos: ' . $e->getMessage()]);
}
$conexion = null;
?>