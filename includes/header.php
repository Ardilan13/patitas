<?php
session_start();

// Obtener la ruta base del proyecto (sin importar en qué carpeta estés)
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$base_url .= "://" . $_SERVER['HTTP_HOST'];

// Detectar la carpeta raíz del proyecto (ajusta "patitas" si tu proyecto tiene otro nombre)
$project_folder = "/patitas/";
$base_url .= $project_folder;

// Detectar sesión activa
$usuario_activo = isset($_SESSION['usuario']);
$nombre_usuario = $usuario_activo ? $_SESSION['usuario']['nombre'] : null;
$tipo_usuario = $usuario_activo ? $_SESSION['usuario']['tipo_usuario'] : null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Pets</title>
    <meta name="keywords" content="cuidado mascotas, paseadores, guardería mascotas, Bucaramanga">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <link rel="icon" type="image/png" href="<?= $base_url ?>assets/img/logo.png">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <img src="<?= $base_url ?>assets/img/logo.png" alt="Secure Pets Logo" class="logo-img">
                    <h1>Secure Pets</h1>
                </div>
                <ul class="nav-menu">
                    <?php if (!$usuario_activo): ?>
                        <!-- Menú público -->
                        <li><a href="<?= $base_url ?>index.php">Inicio</a></li>
                        <li><a href="<?= $base_url ?>pages/nosotros.php">Nosotros</a></li>
                        <li><a href="<?= $base_url ?>pages/registro.php">Crear cuenta</a></li>
                        <li><a href="<?= $base_url ?>pages/login.php" class="btn-login">Iniciar Sesión</a></li>
                    <?php else: ?>
                        <!-- Menú interno (dashboard) -->
                        <li><a href="<?= $base_url ?>pages/dashboard.php">Inicio</a></li>
                        <?php if ($tipo_usuario === 'cuidador'): ?>
                            <li><a href="<?= $base_url ?>pages/anuncios_crear.php">Crear Anuncio</a></li>
                        <?php else: ?>
                            <li><a href="<?= $base_url ?>pages/anuncios_ver.php">Ver Anuncios</a></li>
                        <?php endif; ?>
                        <li><span class="user-name">👋 <?= htmlspecialchars($nombre_usuario) . "-" . htmlspecialchars($tipo_usuario) ?></span></li>
                        <li><a href="<?= $base_url ?>pages/logout.php" class="btn-logout">Cerrar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>