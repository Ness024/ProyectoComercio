<?php
session_start();

if ($_SESSION['correo']) {
    $usuario_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $celular = $_POST['telefono'];

    $calle = $_POST['calle'];
    $colonia = $_POST['colonia'];
    $ciudad = $_POST['ciudad'];
    $cp = $_POST['cp'];
    $numE = $_POST['numE'];
    $numI = $_POST['numI'];
    $referencias = $_POST['referencias'];

    try {
        require 'db_connection.php';

        //consultar Usuario 
        $consultaUsuarios = "SELECT * FROM usuarios WHERE id = :usuario_id";
        $stmtConsultaUsuarios = $conexion->prepare($consultaUsuarios);
        $stmtConsultaUsuarios->bindParam(':usuario_id', $usuario_id);
        $stmtConsultaUsuarios->execute();
        $usuarioExiste = $stmtConsultaUsuarios->fetch(PDO::FETCH_ASSOC);

        if ($usuarioExiste) {
            $nombre = $nombre ?: $usuarioExiste['nombre'];
            $apellido = $apellido ?: $usuarioExiste['apellidos'];
            $celular = $celular ?: $usuarioExiste['celular'];
        }
        
        //Update de Usuario el nombre, apellido y celular
        $update = "UPDATE usuarios SET 
                       nombre = :nombre,
                       apellidos = :apellidos,
                       celular = :celular
                       WHERE id = :usuario_id";
        $stmtUpdate = $conexion->prepare($update);
        $stmtUpdate->bindParam(':nombre', $nombre);
        $stmtUpdate->bindParam(':apellidos', $apellido);
        $stmtUpdate->bindParam(':celular', $celular);
        $stmtUpdate->bindParam(':usuario_id', $usuario_id);
        $stmtUpdate->execute();

        //Consulta de domicilio si ya hay un registro
        $consulta = "SELECT * FROM domicilios WHERE usuario_id = :usuario_id";
        $stmtConsulta = $conexion->prepare($consulta);
        $stmtConsulta->bindParam(':usuario_id', $usuario_id);
        $stmtConsulta->execute();
        $registroExistente = $stmtConsulta->fetch(PDO::FETCH_ASSOC);

        if ($registroExistente) {
            $sql = "UPDATE domicilios SET 
                    direccion = :direccion,
                    colonia = :colonia,
                    ciudad = :ciudad,
                    codigo_postal = :codigo_postal,
                    nro_exterior = :nro_exterior,
                    nro_interior = :nro_interior,
                    descripcion = :referencias
                    WHERE usuario_id = :usuario_id";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':direccion', $calle);
            $stmt->bindParam(':colonia', $colonia);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':codigo_postal', $cp);
            $stmt->bindParam(':nro_exterior', $numE);
            $stmt->bindParam(':nro_interior', $numI);
            $stmt->bindParam(':referencias', $referencias);
            $stmt->bindParam(':usuario_id', $usuario_id);

            $stmt->execute();

            header('Content-Type: application/json');
            echo json_encode(['error' => false, 'mensaje' => 'Dirección actualizada exitosamente']);
        } else {
            $sql = "INSERT INTO domicilios (usuario_id, direccion, colonia, ciudad, codigo_postal, nro_exterior, nro_interior, descripcion) 
                    VALUES (:usuario_id, :direccion, :colonia, :ciudad, :codigo_postal, :nro_exterior, :nro_interior, :referencias)";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':direccion', $calle);
            $stmt->bindParam(':colonia', $colonia);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':codigo_postal', $cp);
            $stmt->bindParam(':nro_exterior', $numE);
            $stmt->bindParam(':nro_interior', $numI);
            $stmt->bindParam(':referencias', $referencias);

            $stmt->execute();

            header('Content-Type: application/json');
            echo json_encode(['error' => false, 'mensaje' => 'Dirección registrada exitosamente']);
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