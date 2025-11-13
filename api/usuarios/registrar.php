<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../config/database.php";

$conn = Database::conectar();

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Error al conectar con la base de datos"]);
    exit;
}

try {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $tipo = $_POST['tipo_usuario'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';

    // verificar si el usuario ya existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        echo json_encode(["success" => false, "message" => "El correo ya está registrado"]);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO usuarios (nombre, apellido, email, telefono, password, tipo_usuario, direccion, ciudad)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$nombre, $apellido, $email, $telefono, $password, $tipo, $direccion, $ciudad]);

    echo json_encode(["success" => true, "message" => "Registro exitoso. ¡Bienvenido a Secure Pets!"]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Error en el servidor."]);
}
