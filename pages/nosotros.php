<?php include '../includes/header.php'; ?>

<!-- HERO CON IMAGEN -->
<section class="hero" style="background: url('../assets/img/baner.jpg') center/cover no-repeat; position: relative; color: white;">
    <div style="background-color: rgba(0,0,0,0.55); position: absolute; top:0; left:0; width:100%; height:100%;"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <h2>Sobre Nosotros 🐶</h2>
        <p>Conoce más sobre <strong>Patitas Seguras</strong>, plataforma que conecta dueños de mascotas con cuidadores apasionados.</p>
        <span>“Más que un cuidado, siempre una compañía segura.”</span>
    </div>
</section>

<section class="container mt-3">
    <div class="dashboard-container" style="background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="color: var(--primary-color); text-align:center;">Nuestra Historia</h2>
        <p style="text-align: justify; margin-top: 1rem;">
            <strong>Patitas Seguras</strong> nació con la misión de brindar tranquilidad a los dueños de mascotas y generar oportunidades para cuidadores apasionados por los animales.
            Nuestra plataforma busca crear conexiones basadas en la confianza, la seguridad y el amor por los peludos que alegran nuestros días.
        </p>

        <div style="display: flex; justify-content: center; margin: 2rem 0;">
            <img src="../assets/img/var1.avif" alt="Perros felices" style="border-radius: 12px; max-width: 100%; width: 700px; object-fit: cover;">
        </div>

        <h2 style="color: var(--primary-color); text-align:center;">Nuestra Misión y Visión 🐾</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 1.5rem;">
            <div style="background: var(--bg-light); padding: 1.5rem; border-radius: 10px;">
                <img src="../assets/img/var2.webp" alt="Misión" style="width:100%; border-radius:10px; margin-bottom:10px;">
                <h3 style="color: var(--secondary-color);">🎯 Misión</h3>
                <p style="text-align: justify;">
                    Facilitar la conexión entre cuidadores y dueños de mascotas mediante una plataforma confiable y amigable, promoviendo el bienestar animal y la seguridad en cada servicio.
                </p>
            </div>
            <div style="background: var(--bg-light); padding: 1.5rem; border-radius: 10px;">
                <img src="../assets/img/var3.jpg" alt="Visión" style="width:100%; border-radius:10px; margin-bottom:10px;">
                <h3 style="color: var(--secondary-color);">🌟 Visión</h3>
                <p style="text-align: justify;">
                    Convertirnos en la comunidad líder de cuidado de mascotas, garantizando experiencias seguras y felices tanto para las mascotas como para sus cuidadores.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="servicios" style="background: var(--cream);">
    <div class="container">
        <h3>Nuestro Factor Diferencial</h3>
        <div class="servicios-grid">
            <div class="servicio-card">
                <div class="icono">🐾</div>
                <h4>Amor Animal</h4>
                <p>Cuidamos a cada mascota como si fuera nuestra.</p>
            </div>
            <div class="servicio-card">
                <div class="icono">🔒</div>
                <h4>Confianza</h4>
                <p>Servicios verificados y seguros para todos.</p>
            </div>
            <div class="servicio-card">
                <div class="icono">🤝</div>
                <h4>Comunidad</h4>
                <p>Conectamos personas con la misma pasión por los animales.</p>
            </div>
            <div class="servicio-card">
                <div class="icono">📱</div>
                <h4>Innovación</h4>
                <p>Plataforma fácil de usar con tecnología avanzada.</p>
            </div>
        </div>
    </div>
</section>

<section class="container mt-3">
    <div class="dashboard-container" style="background: #fff; border-radius: 15px; padding: 2rem;">
        <h2 style="color: var(--primary-color); text-align:center;">Análisis DOFA 🧩</h2>
        <p style="text-align: center; margin-bottom: 1rem;">Explora nuestras fortalezas, oportunidades, debilidades y amenazas.</p>

        <div class="text-center" style="margin: 2rem 0;">
            <img src="../assets/img/dofa.png" alt="Análisis DOFA" id="dofa-image" style="max-width: 90%; border-radius: 10px;">
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>