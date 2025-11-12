<?php
header('Content-Type: application/json');
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $dueno_id = $_POST['dueno_id'] ?? 0;
    $cuidador_id = $_POST['cuidador_id'] ?? 0;
    $tipo_servicio = $_POST['tipo_servicio'] ?? '';
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? null;
    $duracion_horas = $_POST['duracion_horas'] ?? 1;
    $precio_total = $_POST['precio_total'] ?? 0;
    $direccion_servicio = $_POST['direccion_servicio'] ?? '';
    $notas = $_POST['notas'] ?? '';

    // Calcular comisión (7%)
    $comision = $precio_total * 0.07;

    $query = "INSERT INTO reservas 
              (dueno_id, cuidador_id, tipo_servicio, fecha_inicio, fecha_fin, 
               duracion_horas, precio_total, comision_plataforma, direccion_servicio, notas) 
              VALUES 
              (:dueno_id, :cuidador_id, :tipo_servicio, :fecha_inicio, :fecha_fin, 
               :duracion_horas, :precio_total, :comision, :direccion, :notas)";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':dueno_id', $dueno_id);
    $stmt->bindParam(':cuidador_id', $cuidador_id);
    $stmt->bindParam(':tipo_servicio', $tipo_servicio);
    $stmt->bindParam(':fecha_inicio', $fecha_inicio);
    $stmt->bindParam(':fecha_fin', $fecha_fin);
    $stmt->bindParam(':duracion_horas', $duracion_horas);
    $stmt->bindParam(':precio_total', $precio_total);
    $stmt->bindParam(':comision', $comision);
    $stmt->bindParam(':direccion', $direccion_servicio);
    $stmt->bindParam(':notas', $notas);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Reserva creada exitosamente',
            'reserva_id' => $db->lastInsertId()
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al crear reserva']);
    }
}
