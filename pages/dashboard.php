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
            <a href="anuncios_crear.php" class="btn-submit">➕ Crear nuevo anuncio</a>
            <a href="anuncios_ver.php" class="btn-secondary">📋 Ver mis anuncios</a>
        </div>

    <?php elseif ($usuario['tipo_usuario'] === 'dueno'): ?>
        <p>Explora los cuidadores disponibles y encuentra el mejor para tu mascota 🐶🐱</p>
        <a href="anuncios_ver.php" class="btn-submit">🔍 Ver anuncios disponibles</a>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>