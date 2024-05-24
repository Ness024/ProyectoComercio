<?php
session_start();
if (isset($_SESSION['correo'])) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = $_SESSION['correo'];
    $usuarioId = $_SESSION['user_id'];

    try {
      include 'db_connection.php';
      $sql = "SELECT * FROM usuarios WHERE email = :email";
      $stmt = $conexion->prepare($sql);
      $stmt->bindParam(":email", $usuario);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {

        header('Content-Type: application/json');
        echo json_encode($result);
      } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => true, 'mensaje' => 'Usuario no encontrado']);
      }
    } catch (PDOException $e) {
      header('Content-Type: application/json');
      echo json_encode(['error' => true, 'mensaje' => 'Hubo un error: ' . $e->getMessage()]);
    } finally {
      if ($conexion) {
        $conexion = null;
      }
    }
  }
}
?>