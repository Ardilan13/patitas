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
        <p>Gracias por ofrecer tus servicios. Aquí puedes crear y administrar tus anuncios.</p>
        <a href="anuncios_crear.php" class="btn-submit">Crear nuevo anuncio</a>

        <div class="anuncios-lista">
            <h3>Mis anuncios</h3>
            <p>(Aquí se listarán los anuncios del cuidador desde la base de datos)</p>
        </div>

    <?php elseif ($usuario['tipo_usuario'] === 'propietario'): ?>
        <p>Explora los cuidadores disponibles y encuentra el mejor para tu mascota 🐶🐱</p>
        <a href="anuncios_ver.php" class="btn-submit">Ver anuncios disponibles</a>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>