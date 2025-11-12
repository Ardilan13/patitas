<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cuidadores - Patitas Seguras</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="container busqueda-section">
        <h2 style="text-align: center; margin-bottom: 2rem;">
            Encuentra el Cuidador Perfecto
        </h2>

        <div class="filtros">
            <h3>Filtros de Búsqueda</h3>
            <div class="filtros-grid">
                <div class="form-group">
                    <label for="filtro-ciudad">Ciudad</label>
                    <select id="filtro-ciudad">
                        <option value="Bucaramanga">Bucaramanga</option>
                        <option value="Floridablanca">Floridablanca</option>
                        <option value="Girón">Girón</option>
                        <option value="Piedecuesta">Piedecuesta</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="filtro-servicio">Tipo de Servicio</label>
                    <select id="filtro-servicio">
                        <option value="">Todos</option>
                        <option value="paseo">Paseos</option>
                        <option value="cuidado_horas">Cuidado por Horas</option>
                        <option value="guarderia">Guardería</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="cuidadores-container" class="cuidadores-grid">
            <!-- Los cuidadores se cargarán aquí dinámicamente -->
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/main.js"></script>
</body>

</html>