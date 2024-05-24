<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = cleanInput($_POST["nombre"]);
    $apellidos = cleanInput(($_POST["apellidos"]));
    $email = cleanInput(($_POST["email"]));
    $password = $_POST["password"];

    if (!isset($_POST["acepto_terminos"])) {
        die("Debes aceptar los Términos y Condiciones para registrarte.");
    }

    $hashedPassword = /*password_hash(*/$password /*, PASSWORD_DEFAULT)*/;
    include 'db_connection.php';

    $mysql = "SELECT * FROM Usuarios WHERE email=:email";
    $statment = $conexion->prepare($mysql);
    $statment->bindParam(':email', $email, PDO::PARAM_STR);
    $statment->execute();
    $result = $statment->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $errorMessage = "El correo electrónico ya existe";
        header("Location: ../Registrarse.html");
        exit();
    } else {
        try {
            $sql = "INSERT INTO usuarios (nombre, apellidos, email, contrasena) 
                VALUES (:nombre, :apellidos, :email, :contrasena)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $hashedPassword, PDO::PARAM_STR);
            $stmt->execute();

            header("Location: ../Iniciar_Sesion.php");
            exit();
        } catch (PDOException $e) {
            die("Error en la conexión o inserción de datos: " . $e->getMessage());
        }
    }
} else {
    header("Location: ../home.php");
    exit();
}
function cleanInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
?>