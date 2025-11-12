<?php
require_once '../config/database.php';
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?redirect=mis-reservas.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_tipo = $_SESSION['usuario_tipo'];

$database = new Database();
$db = $database->getConnection();

// Obtener reservas según el tipo de usuario
if ($usuario_tipo === 'dueno') {
    $query = "SELECT r.*, 
              CONCAT(u.nombre, ' ', u.apellido) as nombre_cuidador,
              u.telefono as telefono_cuidador,
              c.calificacion_promedio
              FROM reservas r
              INNER JOIN usuarios u ON r.cuidador_id = u.id
              INNER JOIN cuidadores c ON u.id = c.usuario_id
              WHERE r.dueno_id = :usuario_id
              ORDER BY r.fecha_inicio DESC";
} else {
    $query = "SELECT r.*, 
              CONCAT(u.nombre, ' ', u.apellido) as nombre_dueno,
              u.telefono as telefono_dueno,
              u.direccion as direccion_dueno
              FROM reservas r
              INNER JOIN usuarios u ON r.dueno_id = u.id
              WHERE r.cuidador_id = :usuario_id
              ORDER BY r.fecha_inicio DESC";
}

$stmt = $db->prepare($query);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Agrupar reservas por estado
$reservas_agrupadas = [
    'pendiente' => [],
    'confirmada' => [],
    'en_progreso' => [],
    'completada' => [],
    'cancelada' => []
];

foreach ($reservas as $reserva) {
    $reservas_agrupadas[$reserva['estado']][] = $reserva;
}

include '../includes/header.php';
?>

<div class="container mis-reservas-page">
    <div class="page-header">
        <h1>📅 Mis Reservas</h1>
        <p>
            <?php if ($usuario_tipo === 'dueno'): ?>
                Administra tus reservas de cuidado para tus mascotas
            <?php else: ?>
                Administra los servicios que prestarás
            <?php endif; ?>
        </p>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="stats-cards">
        <div class="stat-card pendiente">
            <div class="stat-icon">⏳</div>
            <div class="stat-info">
                <div class="stat-number"><?php echo count($reservas_agrupadas['pendiente']); ?></div>
                <div class="stat-label">Pendientes</div>
            </div>
        </div>
        <div class="stat-card confirmada">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <div class="stat-number"><?php echo count($reservas_agrupadas['confirmada']); ?></div>
                <div class="stat-label">Confirmadas</div>
            </div>
        </div>
        <div class="stat-card en-progreso">
            <div class="stat-icon">🔄</div>
            <div class="stat-info">
                <div class="stat-number"><?php echo count($reservas_agrupadas['en_progreso']); ?></div>
                <div class="stat-label">En Progreso</div>
            </div>
        </div>
        <div class="stat-card completada">
            <div class="stat-icon">🎉</div>
            <div class="stat-info">
                <div class="stat-number"><?php echo count($reservas_agrupadas['completada']); ?></div>
                <div class="stat-label">Completadas</div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filtros-reservas">
        <button class="filtro-btn active" data-estado="todas">Todas (<?php echo count($reservas); ?>)</button>
        <button class="filtro-btn" data-estado="pendiente">Pendientes (<?php echo count($reservas_agrupadas['pendiente']); ?>)</button>
        <button class="filtro-btn" data-estado="confirmada">Confirmadas (<?php echo count($reservas_agrupadas['confirmada']); ?>)</button>
        <button class="filtro-btn" data-estado="en_progreso">En Progreso (<?php echo count($reservas_agrupadas['en_progreso']); ?>)</button>
        <button class="filtro-btn" data-estado="completada">Completadas (<?php echo count($reservas_agrupadas['completada']); ?>)</button>
        <button class="filtro-btn" data-estado="cancelada">Canceladas (<?php echo count($reservas_agrupadas['cancelada']); ?>)</button>
    </div>

    <!-- Lista de reservas -->
    <div class="reservas-container">
        <?php if (count($reservas) > 0): ?>
            <?php foreach ($reservas as $reserva):
                $tipo_servicio_texto = [
                    'paseo' => '🚶 Paseo',
                    'cuidado_horas' => '⏰ Cuidado por Horas',
                    'guarderia' => '🏠 Guardería',
                    'otro' => '✨ Otro Servicio'
                ];

                $estado_clase = [
                    'pendiente' => 'warning',
                    'confirmada' => 'success',
                    'en_progreso' => 'info',
                    'completada' => 'completed',
                    'cancelada' => 'danger'
                ];

                $estado_texto = [
                    'pendiente' => '⏳ Pendiente',
                    'confirmada' => '✅ Confirmada',
                    'en_progreso' => '🔄 En Progreso',
                    'completada' => '🎉 Completada',
                    'cancelada' => '❌ Cancelada'
                ];
            ?>
                <div class="reserva-card" data-estado="<?php echo $reserva['estado']; ?>">
                    <div class="reserva-header">
                        <div class="reserva-tipo">
                            <?php echo $tipo_servicio_texto[$reserva['tipo_servicio']]; ?>
                        </div>
                        <div class="reserva-estado <?php echo $estado_clase[$reserva['estado']]; ?>">
                            <?php echo $estado_texto[$reserva['estado']]; ?>
                        </div>
                    </div>

                    <div class="reserva-body">
                        <div class="reserva-info">
                            <h3>
                                <?php if ($usuario_tipo === 'dueno'): ?>
                                    👤 Cuidador: <?php echo htmlspecialchars($reserva['nombre_cuidador']); ?>
                                    <span class="calificacion-mini">
                                        ⭐ <?php echo number_format($reserva['calificacion_promedio'], 1); ?>
                                    </span>
                                <?php else: ?>
                                    👤 Cliente: <?php echo htmlspecialchars($reserva['nombre_dueno']); ?>
                                <?php endif; ?>
                            </h3>

                            <div class="reserva-detalles">
                                <div class="detalle-item">
                                    <span class="detalle-icon">📅</span>
                                    <span class="detalle-texto">
                                        <strong>Inicio:</strong>
                                        <?php echo date('d/m/Y H:i', strtotime($reserva['fecha_inicio'])); ?>
                                    </span>
                                </div>

                                <?php if ($reserva['fecha_fin']): ?>
                                    <div class="detalle-item">
                                        <span class="detalle-icon">🏁</span>
                                        <span class="detalle-texto">
                                            <strong>Fin:</strong>
                                            <?php echo date('d/m/Y H:i', strtotime($reserva['fecha_fin'])); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($reserva['duracion_horas']): ?>
                                    <div class="detalle-item">
                                        <span class="detalle-icon">⏱️</span>
                                        <span class="detalle-texto">
                                            <strong>Duración:</strong> <?php echo $reserva['duracion_horas']; ?> hora(s)
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div class="detalle-item">
                                    <span class="detalle-icon">📍</span>
                                    <span class="detalle-texto">
                                        <strong>Lugar:</strong>
                                        <?php echo htmlspecialchars($reserva['direccion_servicio'] ?: 'Por definir'); ?>
                                    </span>
                                </div>

                                <div class="detalle-item">
                                    <span class="detalle-icon">💰</span>
                                    <span class="detalle-texto">
                                        <strong>Precio Total:</strong>
                                        <span class="precio-destacado">
                                            $<?php echo number_format($reserva['precio_total'], 0); ?>
                                        </span>
                                    </span>
                                </div>

                                <?php if ($reserva['notas']): ?>
                                    <div class="detalle-item detalle-full">
                                        <span class="detalle-icon">📝</span>
                                        <span class="detalle-texto">
                                            <strong>Notas:</strong>
                                            <?php echo nl2br(htmlspecialchars($reserva['notas'])); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div class="detalle-item">
                                    <span class="detalle-icon">📱</span>
                                    <span class="detalle-texto">
                                        <strong>Contacto:</strong>
                                        <?php
                                        $telefono = $usuario_tipo === 'dueno'
                                            ? $reserva['telefono_cuidador']
                                            : $reserva['telefono_dueno'];
                                        echo htmlspecialchars($telefono);
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="reserva-acciones">
                            <?php if ($reserva['estado'] === 'pendiente'): ?>
                                <?php if ($usuario_tipo === 'cuidador'): ?>
                                    <button class="btn btn-success" onclick="confirmarReserva(<?php echo $reserva['id']; ?>)">
                                        ✅ Confirmar
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-danger" onclick="cancelarReserva(<?php echo $reserva['id']; ?>)">
                                    ❌ Cancelar
                                </button>
                            <?php endif; ?>

                            <?php if ($reserva['estado'] === 'confirmada'): ?>
                                <?php if ($usuario_tipo === 'cuidador'): ?>
                                    <button class="btn btn-primary" onclick="iniciarServicio(<?php echo $reserva['id']; ?>)">
                                        🚀 Iniciar Servicio
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($reserva['estado'] === 'en_progreso'): ?>
                                <?php if ($usuario_tipo === 'cuidador'): ?>
                                    <button class="btn btn-success" onclick="completarServicio(<?php echo $reserva['id']; ?>)">
                                        ✔️ Completar
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($reserva['estado'] === 'completada'): ?>
                                <button class="btn btn-secondary" onclick="verDetalle(<?php echo $reserva['id']; ?>)">
                                    👁️ Ver Detalle
                                </button>
                                <?php if ($usuario_tipo === 'dueno'): ?>
                                    <button class="btn btn-primary" onclick="calificar(<?php echo $reserva['id']; ?>, <?php echo $reserva['cuidador_id']; ?>)">
                                        ⭐ Calificar
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <button class="btn btn-outline" onclick="contactar('<?php echo $telefono; ?>')">
                                💬 Contactar
                            </button>
                        </div>
                    </div>

                    <div class="reserva-footer">
                        <small>Reserva #<?php echo $reserva['id']; ?> - Creada el <?php echo date('d/m/Y', strtotime($reserva['fecha_creacion'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>No tienes reservas aún</h3>
                <p>
                    <?php if ($usuario_tipo === 'dueno'): ?>
                        Encuentra un cuidador para tu mascota y crea tu primera reserva
                    <?php else: ?>
                        Espera a que los dueños de mascotas te contacten
                    <?php endif; ?>
                </p>
                <?php if ($usuario_tipo === 'dueno'): ?>
                    <a href="buscar-cuidadores.php" class="btn btn-primary">
                        🔍 Buscar Cuidadores
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .mis-reservas-page {
        padding: 2rem 0;
        min-height: calc(100vh - 200px);
    }

    .page-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-header h1 {
        color: var(--dark-color);
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        color: var(--medium-brown);
        font-size: 1.1rem;
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
        border-left: 4px solid;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.pendiente {
        border-left-color: var(--warning-color);
    }

    .stat-card.confirmada {
        border-left-color: var(--success-color);
    }

    .stat-card.en-progreso {
        border-left-color: var(--primary-color);
    }

    .stat-card.completada {
        border-left-color: var(--secondary-color);
    }

    .stat-icon {
        font-size: 2.5rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--dark-color);
    }

    .stat-label {
        color: var(--medium-brown);
        font-size: 0.95rem;
    }

    .filtros-reservas {
        display: flex;
        gap: 0.8rem;
        margin-bottom: 2rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .filtro-btn {
        padding: 0.7rem 1.5rem;
        border: 2px solid var(--cream);
        background: white;
        color: var(--dark-color);
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
        font-weight: 500;
    }

    .filtro-btn:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .filtro-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .reservas-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .reserva-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .reserva-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .reserva-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.2rem 1.5rem;
        background: var(--cream);
        border-bottom: 2px solid var(--primary-color);
    }

    .reserva-tipo {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--dark-color);
    }

    .reserva-estado {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .reserva-estado.warning {
        background: #FFF3CD;
        color: #856404;
    }

    .reserva-estado.success {
        background: #D4EDDA;
        color: #155724;
    }

    .reserva-estado.info {
        background: #D1ECF1;
        color: #0C5460;
    }

    .reserva-estado.completed {
        background: #D1F2EB;
        color: #0C5E4C;
    }

    .reserva-estado.danger {
        background: #F8D7DA;
        color: #721C24;
    }

    .reserva-body {
        padding: 1.5rem;
    }

    .reserva-info h3 {
        color: var(--dark-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .calificacion-mini {
        font-size: 0.9rem;
        color: var(--warning-color);
    }

    .reserva-detalles {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .detalle-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .detalle-item.detalle-full {
        grid-column: 1 / -1;
    }

    .detalle-icon {
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .detalle-texto {
        flex: 1;
        line-height: 1.5;
    }

    .precio-destacado {
        color: var(--primary-color);
        font-weight: bold;
        font-size: 1.1rem;
    }

    .reserva-acciones {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-success {
        background: var(--success-color);
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-secondary {
        background: var(--medium-brown);
        color: white;
    }

    .btn-outline {
        background: white;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .reserva-footer {
        padding: 1rem 1.5rem;
        background: var(--bg-light);
        border-top: 1px solid var(--cream);
        color: var(--medium-brown);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
    }

    .empty-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--medium-brown);
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .reserva-detalles {
            grid-template-columns: 1fr;
        }

        .filtros-reservas {
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .reserva-acciones {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<script src="../assets/js/main.js"></script>
<script>
    // Filtrar reservas por estado
    document.querySelectorAll('.filtro-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Actualizar botón activo
            document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const estado = this.dataset.estado;
            const reservas = document.querySelectorAll('.reserva-card');

            reservas.forEach(reserva => {
                if (estado === 'todas' || reserva.dataset.estado === estado) {
                    reserva.style.display = 'block';
                } else {
                    reserva.style.display = 'none';
                }
            });
        });
    });

    // Funciones de acciones
    function confirmarReserva(id) {
        if (confirm('¿Confirmar esta reserva?')) {
            actualizarEstado(id, 'confirmada');
        }
    }

    function cancelarReserva(id) {
        if (confirm('¿Estás seguro de cancelar esta reserva?')) {
            actualizarEstado(id, 'cancelada');
        }
    }

    function iniciarServicio(id) {
        if (confirm('¿Iniciar el servicio ahora?')) {
            actualizarEstado(id, 'en_progreso');
        }
    }

    function completarServicio(id) {
        if (confirm('¿Marcar el servicio como completado?')) {
            actualizarEstado(id, 'completada');
        }
    }

    async function actualizarEstado(id, nuevoEstado) {
        try {
            const response = await fetch('../api/actualizar-reserva.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id,
                    estado: nuevoEstado
                })
            });

            const data = await response.json();

            if (data.success) {
                alert('Reserva actualizada exitosamente');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            alert('Error de conexión');
        }
    }

    function contactar(telefono) {
        window.location.href = `https://wa.me/57${telefono}`;
    }

    function verDetalle(id) {
        window.location.href = `detalle-reserva.php?id=${id}`;
    }

    function calificar(reservaId, cuidadorId) {
        window.location.href = `calificar.php?reserva=${reservaId}&cuidador=${cuidadorId}`;
    }
</script>

<?php include '../includes/footer.php'; ?>