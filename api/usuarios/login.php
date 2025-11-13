<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../config/database.php";

$conn = Database::conectar();

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Error al conectar con la base de datos"]);
    exit;
}

try {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // podrías guardar sesión aquí si lo deseas
        echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Correo o contraseña incorrectos"]);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Error en el servidor."]);
}
