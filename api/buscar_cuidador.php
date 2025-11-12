<?php header('Content-Type: application/json');
require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$ciudad = $_GET['ciudad'] ?? 'Bucaramanga';
$tipo_servicio = $_GET['tipo_servicio'] ?? '';

$query = "SELECT u.id, u.nombre, u.apellido, u.ciudad, u.telefono,
                 c.descripcion, c.precio_paseo, c.precio_hora, c.precio_dia,
                 c.calificacion_promedio, c.total_servicios, c.foto_perfil,
                 c.tipos_mascotas, c.servicios_ofrecidos, c.verificado
          FROM usuarios u
          INNER JOIN cuidadores c ON u.id = c.usuario_id
          WHERE u.tipo_usuario = 'cuidador' 
          AND u.activo = TRUE
          AND u.ciudad = :ciudad";

$stmt = $db->prepare($query);
$stmt->bindParam(':ciudad', $ciudad);
$stmt->execute();

$cuidadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'cuidadores' => $cuidadores]);
