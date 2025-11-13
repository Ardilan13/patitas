<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>Crear cuenta</h2>
    <div id="alert"></div>
    <form id="registroForm" action="../api/usuarios/registrar.php" method="POST">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="form-group">
            <label>Apellido</label>
            <input type="text" name="apellido" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono">
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Tipo de usuario</label>
            <select name="tipo_usuario" required>
                <option value="">Selecciona...</option>
                <option value="cuidador">Cuidador</option>
                <option value="propietario">Propietario</option>
            </select>
        </div>

        <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion">
        </div>

        <div class="form-group">
            <label>Ciudad</label>
            <input type="text" name="ciudad" value="Bucaramanga">
        </div>

        <button type="submit" class="btn-submit">Registrarse</button>
    </form>
</div>

<script src="../assets/js/main.js"></script>
<script>
    document.getElementById('registroForm').addEventListener('submit', (e) => {
        e.preventDefault();
        enviarFormulario('registroForm', 'alert', 'login.php');
    });
</script>

<?php include '../includes/footer.php'; ?>