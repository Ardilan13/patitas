<?php include '../includes/header.php'; ?>
<?php if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
} ?>
<div class="dashboard-container">
    <h2><?= $_SESSION['usuario']['tipo_usuario'] === 'cuidador' ? 'Mis anuncios' : 'Anuncios disponibles'; ?> 🐾</h2>
    <div id="anuncios-container" class="anuncios-grid"></div>
</div>
<?php include '../includes/footer.php'; ?>