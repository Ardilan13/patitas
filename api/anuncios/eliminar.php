<?php
require_once __DIR__ . "/../../config/database.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_usuario'] !== 'cuidador') {
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

$conn = Database::conectar();
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID no recibido"]);
    exit;
}

// Solo puede borrar sus propios anuncios
$stmt = $conn->prepare("DELETE FROM reservas WHERE id = ? AND cuidador_id = ?");
$ok = $stmt->execute([$id, $_SESSION['usuario']['id']]);

echo json_encode([
    "success" => $ok && $stmt->rowCount() > 0,
    "message" => $ok && $stmt->rowCount() > 0 ? "Anuncio eliminado" : "No se pudo eliminar"
]);
