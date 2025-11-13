<?php
// Detectar la ruta base (por ejemplo: http://localhost/patitas/)
$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 2) . "/";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patitas Seguras - Cuidado de Mascotas en Bucaramanga</title>
    <meta name="keywords" content="cuidado mascotas, paseadores, guardería mascotas, Bucaramanga">

    <!-- 🔗 Rutas absolutas dinámicas -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
    <link rel="icon" type="image/png" href="<?= $base_url ?>assets/img/logo.png">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <h1>🐾 Patitas Seguras</h1>
                </div>
                <ul class="nav-menu">
                    <li><a href="<?= $base_url ?>index.php">Inicio</a></li>
                    <li><a href="<?= $base_url ?>pages/buscar_cuidador.php">Buscar Cuidadores</a></li>
                    <li><a href="<?= $base_url ?>pages/registro.php">Crear cuenta</a></li>
                    <li><a href="<?= $base_url ?>pages/login.php" class="btn-login">Iniciar Sesión</a></li>
                </ul>
            </div>
        </nav>
    </header>