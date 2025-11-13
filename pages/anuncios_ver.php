<?php include '../includes/header.php'; ?>
<?php if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
} ?>
<div class="dashboard-container">
    <h2><?= $_SESSION['usuario']['tipo_usuario'] === 'cuidador' ? 'Mis anuncios' : 'Anuncios disponibles'; ?> 🐾</h2>

    <!-- Panel de filtros -->
    <div class="filtros-container">
        <div class="filtro-grupo">
            <label for="filtro-servicio">Tipo de servicio:</label>
            <select id="filtro-servicio">
                <option value="">Todos</option>
                <option value="paseo">Paseo</option>
                <option value="guarderia">Guardería</option>
                <option value="cuidado_horas">Cuidado por horas</option>
                <option value="otro">Otro</option>
            </select>
        </div>

        <div class="filtro-grupo">
            <label for="filtro-precio-min">Precio mínimo:</label>
            <input type="number" id="filtro-precio-min" placeholder="$0" min="0">
        </div>

        <div class="filtro-grupo">
            <label for="filtro-precio-max">Precio máximo:</label>
            <input type="number" id="filtro-precio-max" placeholder="Sin límite" min="0">
        </div>

        <div class="filtro-grupo">
            <label for="filtro-fecha">Fecha de inicio:</label>
            <input type="date" id="filtro-fecha">
        </div>

        <div class="filtro-grupo">
            <label for="filtro-ordenar">Ordenar por:</label>
            <select id="filtro-ordenar">
                <option value="fecha-desc">Más recientes</option>
                <option value="fecha-asc">Más antiguos</option>
                <option value="precio-asc">Precio: menor a mayor</option>
                <option value="precio-desc">Precio: mayor a menor</option>
            </select>
        </div>

        <button id="btn-limpiar-filtros" class="btn-secondary">Limpiar filtros</button>
    </div>

    <div id="anuncios-container" class="anuncios-grid"></div>
</div>

<?php include '../includes/footer.php'; ?>