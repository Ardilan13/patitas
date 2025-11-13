<?php include '../includes/header.php'; ?>
<?php if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo_usuario'] !== 'cuidador') {
    header("Location: login.php");
    exit;
} ?>
<div class="form-container">
    <h2>Crear Anuncio 🐕</h2>
    <form id="form-crear-anuncio">
        <div class="form-group">
            <label>Tipo de servicio</label>
            <select name="tipo_servicio" required>
                <option value="paseo">Paseo</option>
                <option value="cuidado_horas">Cuidado por horas</option>
                <option value="guarderia">Guardería</option>
                <option value="otro">Otro</option>
            </select>
        </div>
        <div class="form-group">
            <label>Fecha inicio</label>
            <input type="datetime-local" name="fecha_inicio" required>
        </div>
        <div class="form-group">
            <label>Fecha fin</label>
            <input type="datetime-local" name="fecha_fin">
        </div>
        <div class="form-group">
            <label>Precio total</label>
            <input type="number" step="0.01" name="precio_total" required>
        </div>
        <div class="form-group">
            <label>Notas (opcional)</label>
            <textarea name="notas"></textarea>
        </div>
        <button type="submit" class="btn-submit">Crear anuncio</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>