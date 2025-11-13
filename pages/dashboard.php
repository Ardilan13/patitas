<?php
include '../includes/header.php';

// Redirigir si no hay sesión activa
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
?>
<div class="dashboard-container">
    <h2>Bienvenido, <?= htmlspecialchars($usuario['nombre']); ?> 🐾</h2>

    <?php if ($usuario['tipo_usuario'] === 'cuidador'): ?>
        <p>Gracias por ofrecer tus servicios. Aquí puedes administrar tus anuncios.</p>
        <div class="dashboard-actions">
            <a href="<?= $base_url ?>pages/anuncios_crear.php" class="btn-submit">➕ Crear nuevo anuncio</a>
            <a href="<?= $base_url ?>pages/anuncios_ver.php" class="btn btn-secondary">📋 Ver mis anuncios</a>
            <a href="<?= $base_url ?>pages/reservas.php" class="btn btn-secondary">📅 Ver mis reservados</a>
        </div>

    <?php elseif ($usuario['tipo_usuario'] === 'dueno'): ?>
        <p>Explora los cuidadores disponibles y encuentra el mejor para tu mascota 🐶🐱</p>
        <div class="dashboard-actions">
            <a href="<?= $base_url ?>pages/anuncios_ver.php" class="btn-submit">🔍 Ver anuncios disponibles</a>
            <a href="<?= $base_url ?>pages/reservas.php" class="btn btn-secondary">📅 Mis reservas</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>