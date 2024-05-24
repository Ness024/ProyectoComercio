<?php
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require 'db_connection.php';
        $buscando = $_POST['searchTerm'];

        $buscar = "SELECT * FROM productos WHERE nombre LIKE :buscando";
        $stmt = $conexion->prepare($buscar);
        $stmt->bindValue(':buscando', '%' . $buscando . '%');
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($results);
    }
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => true, 'mensaje' => 'Error en la base de datos: ' . $e->getMessage()]);
} finally {
    if (isset($conexion)) {
        $conexion = null;
    }
}
?>