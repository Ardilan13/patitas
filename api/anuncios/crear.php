<?php
require_once __DIR__ . "/../../config/database.php";
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_usuario'] !== 'cuidador') {
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

$conn = Database::conectar();
$data = json_decode(file_get_contents("php://input"), true);

$cuidador_id = $_SESSION['usuario']['id'];
$tipo_servicio = $data['tipo_servicio'] ?? 'paseo';
$fecha_inicio = $data['fecha_inicio'] ?? date('Y-m-d H:i:s');
$fecha_fin = $data['fecha_fin'] ?? null;
$precio_total = $data['precio_total'] ?? 0;
$notas = $data['notas'] ?? '';

$stmt = $conn->prepare("INSERT INTO reservas (cuidador_id, tipo_servicio, fecha_inicio, fecha_fin, precio_total, notas)
                        VALUES (?, ?, ?, ?, ?, ?)");
$ok = $stmt->execute([$cuidador_id, $tipo_servicio, $fecha_inicio, $fecha_fin, $precio_total, $notas]);

echo json_encode(["success" => $ok, "message" => $ok ? "Anuncio creado" : "Error al crear anuncio"]);
