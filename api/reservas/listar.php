<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../config/database.php";
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

$usuario = $_SESSION['usuario'];
$conn = Database::conectar();

try {
    if ($usuario['tipo_usuario'] === 'cuidador') {
        // Reservas que han hecho a mis servicios
        $stmt = $conn->prepare("
            SELECT 
                r.id, r.tipo_servicio, r.fecha_inicio, r.fecha_fin, r.duracion_horas,
                r.precio_total, r.estado, r.direccion_servicio, r.notas,
                u.nombre AS dueno_nombre, u.email AS dueno_email, u.telefono AS dueno_telefono
            FROM reservas r
            INNER JOIN usuarios u ON r.dueno_id = u.id
            WHERE r.cuidador_id = ?
            ORDER BY r.fecha_inicio DESC
        ");
        $stmt->execute([$usuario['id']]);
    } else {
        // Reservas que yo como dueño he hecho
        $stmt = $conn->prepare("
            SELECT 
                r.id, r.tipo_servicio, r.fecha_inicio, r.fecha_fin, r.duracion_horas,
                r.precio_total, r.estado, r.direccion_servicio, r.notas,
                u.nombre AS cuidador_nombre, u.email AS cuidador_email, u.telefono AS cuidador_telefono
            FROM reservas r
            INNER JOIN usuarios u ON r.cuidador_id = u.id
            WHERE r.dueno_id = ?
            ORDER BY r.fecha_inicio DESC
        ");
        $stmt->execute([$usuario['id']]);
    }

    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["success" => true, "data" => $reservas]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(["success" => false, "message" => "Error al obtener reservas."]);
}
