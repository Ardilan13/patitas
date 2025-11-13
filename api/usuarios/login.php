<?php
header("Content-Type: application/json");
session_start();
require_once __DIR__ . "/../../config/database.php";

$conn = Database::conectar();

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Error al conectar con la base de datos"]);
    exit;
}

try {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, nombre, password, tipo_usuario FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario'] = [
            'id' => $user['id'],
            'nombre' => $user['nombre'],
            'tipo_usuario' => $user['tipo_usuario']
        ];

        echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Correo o contraseña incorrectos"]);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Error en el servidor."]);
}
