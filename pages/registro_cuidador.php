<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Cuidador - Patitas Seguras</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="form-container">
            <h2>🐾 Registro de Cuidador</h2>
            <p style="text-align: center; margin-bottom: 2rem;">
                Únete a nuestra red de cuidadores verificados
            </p>

            <form id="form-registro-cuidador">
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
                    <label for="direccion">Dirección *</label>
                    <input type="text" name="direccion" id="direccion" required>
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
                    <label for="experiencia">Años de Experiencia</label>
                    <input type="number" name="experiencia_anos" id="experiencia" min="0" max="50">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción (cuéntanos sobre ti)</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                        placeholder="Describe tu experiencia, qué te motiva a cuidar mascotas, etc."></textarea>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña * (mínimo 6 caracteres)</label>
                    <input type="password" name="password" id="password" required minlength="6">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña *</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label>
                        <input type="checkbox" required>
                        Acepto los términos y condiciones y la política de privacidad
                    </label>
                </div>

                <button type="submit" class="btn-submit">Registrarse como Cuidador</button>

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