<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: Iniciar_Sesion.php");
} else {
    $usuario = $_SESSION["correo"];
    $id = $_SESSION["user_id"];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nuevo_nombre = $_POST['nombre'];
        $nuevos_apellidos = $_POST['apellidos'];

        $nuevo_celular = $_POST['celular'];
        $nuevo_cliente = $_POST['cliente'];
        $nuevo_email = $_POST['email'];
        //$nuevo_sexo = $_POST['sexo'];
        $nuevo_dia = isset($_POST['dia']) ? $_POST['dia'] : null;
        $nuevo_mes = isset($_POST['mes']) ? $_POST['mes'] : null;
        $nuevo_anio = isset($_POST['ano']) ? $_POST['ano'] : null;

        if ($_POST['email'] !== $_SESSION["correo"]) {
            $_SESSION["correo"] = $nuevo_email;
        }

        if ($nuevo_dia !== null && $nuevo_mes !== null && $nuevo_anio !== null) {
            $dia_formateado = sprintf("%02d", $nuevo_dia);
            $mes_formateado = sprintf("%02d", $nuevo_mes);
            $fechaNacimiento = $nuevo_anio . '-' . $mes_formateado . '-' . $dia_formateado;
        } else {
            $fechaNacimiento = null;
        }


        if (isset($_FILES['cargarImagen']) && $_FILES['cargarImagen']['error'] === UPLOAD_ERR_OK) {
            $nombre_temporal = $_FILES['cargarImagen']['tmp_name'];
            $nombre_archivo = $_FILES['cargarImagen']['name'];
            $ruta_destino = 'Resources/perfil/' . $nombre_archivo;

            move_uploaded_file($nombre_temporal, $ruta_destino);
            $fotoPerfil = $ruta_destino;
        } else {
            try {
                require 'db_connection.php';
                $consulta = "SELECT avatar FROM usuarios WHERE email=:correo";

                $consultaStmt = $conexion->prepare($consulta);
                $consultaStmt->bindParam(':correo', $usuario);
                $consultaStmt->execute();
                $result = $consultaStmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $fotoPerfil = $result['avatar'];
                } else {
                    $fotoPerfil = null;
                }
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode(['error' => true, 'mensaje' => 'Hubo un errorexpcosnulta: ' . $e->getMessage()]);
            }
        }

        try {
            require 'db_connection.php';

            $sql = "UPDATE usuarios SET 
                nombre = :nuevo_nombre,
                apellidos = :nuevos_apellidos,
                email = :nuevo_email,
                celular = :nuevo_celular,
                numero_cliente = :nuevo_cliente,
                fecha_nacimiento = :fechaNacimiento,
                avatar = :fotoPerfil
                WHERE id = :id";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nuevo_nombre', $nuevo_nombre);
            $stmt->bindParam(':nuevos_apellidos', $nuevos_apellidos);
            $stmt->bindParam(':nuevo_email', $nuevo_email);
            $stmt->bindParam(':nuevo_celular', $nuevo_celular);
            $stmt->bindParam(':nuevo_cliente', $nuevo_cliente);
            $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
            $stmt->bindParam(':fotoPerfil', $fotoPerfil);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                header('Content-Type: application/json');
                echo json_encode(['error' => false, 'mensaje' => 'Exito']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['error' => true, 'mensaje' => 'Hubo un error al ejecutar: ' . $e->getMessage()]);
            }
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => true, 'mensaje' => 'Hubo un error PDOException: ' . $e->getMessage()]);
        } finally {
            if ($conexion) {
                $conexion = null;
            }
        }


    }
}
?>