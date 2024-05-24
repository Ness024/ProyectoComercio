<?php
session_start();

if ($_SESSION['correo']) {
    $usuario_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db_connection.php';

    $primer_nombre = $_POST['nombre'];
    $segundo_nombre = $_POST['segundo-nombre'];
    $apellido_titular = $_POST['titular'];
    $numero_tarjeta = $_POST['numerodetarjeta'];
    $fecha_expiracion = $_POST['fecha'];
    $cvv = $_POST['cvv'];

    try {
        $consulta = "SELECT * FROM tarjetas WHERE usuario_id = :usuario_id";
        $stmtConsulta = $conexion->prepare($consulta);
        $stmtConsulta->bindParam(':usuario_id', $usuario_id);
        $stmtConsulta->execute();
        $tarjetaExistente = $stmtConsulta->fetch(PDO::FETCH_ASSOC);

        if ($tarjetaExistente) {
            $update = "UPDATE tarjetas SET 
                        primer_nombre = :primer_nombre,
                        segundo_nombre = :segundo_nombre,
                        apellido_titular = :apellido_titular,
                        numero_tarjeta = :numero_tarjeta,
                        fecha_expiracion = :fecha_expiracion,
                        cvv = :cvv
                        WHERE usuario_id = :usuario_id";

            $stmtUpdate = $conexion->prepare($update);
            $stmtUpdate->bindParam(':primer_nombre', $primer_nombre);
            $stmtUpdate->bindParam(':segundo_nombre', $segundo_nombre);
            $stmtUpdate->bindParam(':apellido_titular', $apellido_titular);
            $stmtUpdate->bindParam(':numero_tarjeta', $numero_tarjeta);
            $stmtUpdate->bindParam(':fecha_expiracion', $fecha_expiracion);
            $stmtUpdate->bindParam(':cvv', $cvv);
            $stmtUpdate->bindParam(':usuario_id', $usuario_id);

            $stmtUpdate->execute();

            header('Content-Type: application/json');
            echo json_encode(['error' => false, 'mensaje' => 'tarjeta actualizada exitosamente']);
        } else {
            $sql = "INSERT INTO tarjetas (usuario_id, primer_nombre, segundo_nombre, apellido_titular, numero_tarjeta, fecha_expiracion, cvv)
            VALUES (:usuario_id, :primer_nombre, :segundo_nombre, :apellido_titular, :numero_tarjeta, :fecha_expiracion, :cvv)";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':primer_nombre', $primer_nombre);
            $stmt->bindParam(':segundo_nombre', $segundo_nombre);
            $stmt->bindParam(':apellido_titular', $apellido_titular);
            $stmt->bindParam(':numero_tarjeta', $numero_tarjeta);
            $stmt->bindParam(':fecha_expiracion', $fecha_expiracion);
            $stmt->bindParam(':cvv', $cvv);

            $stmt->execute();

            header('Content-Type: application/json');
            echo json_encode(['error' => false, 'mensaje' => 'Tarjeta guardada exitosamente']);
        }
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