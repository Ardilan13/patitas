<?php
include '../includes/header.php';
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
$usuario = $_SESSION['usuario'];
?>

<div class="dashboard-container">
    <h2>Mis reservas 🐾</h2>
    <div id="reservas-container">
        <p>Cargando reservas...</p>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const contenedor = document.getElementById("reservas-container");

        try {
            const res = await fetch("../api/reservas/listar.php");
            const data = await res.json();

            if (!data.success || data.data.length === 0) {
                contenedor.innerHTML = "<p>No hay reservas registradas por el momento.</p>";
                return;
            }

            contenedor.innerHTML = `
            <div class="reservas-grid">
                ${data.data.map(r => `
                    <div class="reserva-card">
                        <h3>${r.tipo_servicio.toUpperCase()}</h3>
                        ${r.dueno_nombre ? `
                            <p><strong>Dueño:</strong> ${r.dueno_nombre}</p>
                            <p><strong>Email:</strong> ${r.dueno_email}</p>
                            <p><strong>Telefono:</strong> ${r.dueno_telefono}</p>
                        ` : `
                            <p><strong>Cuidador:</strong> ${r.cuidador_nombre}</p>
                            <p><strong>Email:</strong> ${r.cuidador_email}</p>
                            <p><strong>Telefono:</strong> ${r.cuidador_telefono}</p>
                        `}
                        <p><strong>Desde:</strong> ${r.fecha_inicio}</p>
                        <p><strong>Hasta:</strong> ${r.fecha_fin || '—'}</p>
                        <p><strong>Duración:</strong> ${r.duracion_horas ? r.duracion_horas + 'h' : 'N/A'}</p>
                        <p><strong>Precio total:</strong> $${r.precio_total}</p>
                        <p><strong>Dirección:</strong> ${r.direccion_servicio || 'No especificada'}</p>
                        ${r.notas ? `<p><strong>Notas:</strong> ${r.notas}</p>` : ''}
                        <p><strong>Estado:</strong>
                            <span class="estado ${r.estado.toLowerCase()}">${r.estado}</span>
                        </p>
                        ${window.tipoUsuario === "dueno" ? `<button class="btn-cancelar" data-id="${r.id}">Cancelar reserva</button>` : ""}
                    </div>
                `).join("")}
            </div>
        `;
        } catch (err) {
            contenedor.innerHTML = "<p>Error al cargar las reservas.</p>";
            console.error(err);
        }
    });
</script>

<?php include '../includes/footer.php'; ?>