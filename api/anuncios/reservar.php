<?php
require_once __DIR__ . "/../../config/database.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_usuario'] !== 'dueno') {
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

$conn = Database::conectar();
$data = json_decode(file_get_contents("php://input"), true);
$dueno_id = $_SESSION['usuario']['id'];
$reserva_id = $data['id'] ?? null;

if (!$reserva_id) {
    echo json_encode(["success" => false, "message" => "ID de anuncio no proporcionado"]);
    exit;
}

$stmt = $conn->prepare("UPDATE reservas SET dueno_id = ?, estado = 'confirmada' WHERE id = ?");
$ok = $stmt->execute([$dueno_id, $reserva_id]);

echo json_encode(["success" => $ok, "message" => $ok ? "Reserva confirmada" : "Error al reservar"]);
