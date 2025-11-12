<?php
// ============================================
// api/registrar-usuario.php
// ============================================
header('Content-Type: application/json');
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $password = $_POST['password'] ?? '';
    $tipo_usuario = $_POST['tipo_usuario'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? 'Bucaramanga';

    // Validaciones
    if (empty($nombre) || empty($email) || empty($password) || empty($tipo_usuario)) {
        echo json_encode(['success' => false, 'message' => 'Campos obligatorios faltantes']);
        exit;
    }

    // Verificar si el email ya existe
    $query = "SELECT id FROM usuarios WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'El email ya está registrado']);
        exit;
    }

    // Hash de contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $query = "INSERT INTO usuarios (nombre, apellido, email, telefono, password, tipo_usuario, direccion, ciudad) 
              VALUES (:nombre, :apellido, :email, :telefono, :password, :tipo_usuario, :direccion, :ciudad)";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(':tipo_usuario', $tipo_usuario);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':ciudad', $ciudad);

    if ($stmt->execute()) {
        $usuario_id = $db->lastInsertId();

        // Si es cuidador, crear perfil de cuidador
        if ($tipo_usuario === 'cuidador') {
            $query = "INSERT INTO cuidadores (usuario_id) VALUES (:usuario_id)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
        }

        echo json_encode(['success' => true, 'message' => 'Registro exitoso', 'usuario_id' => $usuario_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
    }
}
