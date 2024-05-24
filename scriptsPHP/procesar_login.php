<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        require 'db_connection.php';
        $sql = "SELECT * FROM usuarios WHERE email = :email";

        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':email', $email);
        $consulta->execute();
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            //if ($usuario && password_verify($password, $usuario['contrasena'])) {
            if ($password == $usuario['contrasena']) {
                session_start();
                $_SESSION["user_id"] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION["correo"] = $usuario['email'];
                $_SESSION["avatar"] = $usuario['avatar'];
                header("Location: ../perfilDeUsuario.php");
                exit();
            } else {
                $_SESSION["errorMessage"] = "Contraseña Invalida. Por favor, inténtelo de nuevo.";
                $_SESSION["e-mail"] = $email;
                header("Location: ../Iniciar_Sesion.php?error=credenciales");
                exit();
            }
        } else {
            $_SESSION["errorMessage"] = "Usuario No Existe. Por favor, inténtelo de nuevo.";
            header("Location: ../Iniciar_Sesion.php?error=credenciales");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error en la conexión o consulta: " . $e->getMessage(), 0);
        header("Location: ../Iniciar_Sesion.php");
        exit();
    }
} else {
    header("Location: Iniciar_Sesion.php");
    exit();
}
?>