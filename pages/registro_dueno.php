<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Dueño - Patitas Seguras</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="form-container">
            <h2>🐾 Registro de Dueño</h2>
            <p style="text-align: center; margin-bottom: 2rem;">
                Encuentra el cuidador perfecto para tu mascota
            </p>

            <form id="form-registro-dueno">
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido *</label>
                    <input type="text" name="apellido" id="apellido" required>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono * (10 dígitos)</label>
                    <input type="tel" name="telefono" id="telefono" placeholder="3001234567" required>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion">
                </div>

                <div class="form-group">
                    <label for="ciudad">Ciudad *</label>
                    <select name="ciudad" id="ciudad" required>
                        <option value="Bucaramanga">Bucaramanga</option>
                        <option value="Floridablanca">Floridablanca</option>
                        <option value="Girón">Girón</option>
                        <option value="Piedecuesta">Piedecuesta</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña * (mínimo 6 caracteres)</label>
                    <input type="password" name="password" id="password" required minlength="6">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña *</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>

                <button type="submit" class="btn-submit">Registrarse</button>

                <p style="text-align: center; margin-top: 1rem;">
                    ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
                </p>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/main.js"></script>
</body>

</html>