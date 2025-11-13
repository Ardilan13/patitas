<?php
require_once __DIR__ . "/../../config/database.php";
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode([]);
    exit;
}

$conn = Database::conectar();
$usuario = $_SESSION['usuario'];

if ($usuario['tipo_usuario'] === 'cuidador') {
    $stmt = $conn->prepare("SELECT * FROM reservas WHERE cuidador_id = ?");
    $stmt->execute([$usuario['id']]);
} else {
    $stmt = $conn->query("SELECT r.*, u.nombre AS cuidador_nombre
                          FROM reservas r
                          JOIN usuarios u ON r.cuidador_id = u.id
                          WHERE r.dueno_id IS NULL AND r.estado = 'pendiente'");
}

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
