<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../config/database.php";
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

$usuario = $_SESSION['usuario'];

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID no recibido"]);
    exit;
}

$conn = Database::conectar();

try {
    // Solo el DUEÑO de la reserva puede cancelarla
    $stmt = $conn->prepare("SELECT dueno_id FROM reservas WHERE id = ?");
    $stmt->execute([$id]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserva || $reserva['dueno_id'] != $usuario['id']) {
        echo json_encode(["success" => false, "message" => "No autorizado"]);
        exit;
    }

    // Cancelar reserva: remover dueño y estado
    $stmt = $conn->prepare("
        UPDATE reservas
        SET dueno_id = NULL,
            estado = 'Disponible'
        WHERE id = ?
    ");
    $ok = $stmt->execute([$id]);

    echo json_encode([
        "success" => $ok,
        "message" => $ok ? "Reserva cancelada correctamente" : "No se pudo cancelar"
    ]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Error interno"]);
}
