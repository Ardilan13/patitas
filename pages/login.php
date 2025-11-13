<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>Iniciar Sesión</h2>
    <div id="alert"></div>
    <form id="loginForm" action="../api/usuarios/login.php" method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn-submit">Ingresar</button>
    </form>
</div>

<script src="../assets/js/main.js"></script>
<script>
    document.getElementById('loginForm').addEventListener('submit', (e) => {
        e.preventDefault();
        enviarFormulario('loginForm', 'alert', '<?= $base_url ?>pages/dashboard.php');
    });
</script>

<?php include '../includes/footer.php'; ?>