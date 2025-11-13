document.addEventListener("DOMContentLoaded", () => {
  const crearForm = document.getElementById("form-crear-anuncio");
  const contenedor = document.getElementById("anuncios-container");

  // Crear anuncio
  if (crearForm) {
    crearForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const data = Object.fromEntries(new FormData(crearForm).entries());

      const res = await fetch("../api/anuncios/crear.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
      });
      const json = await res.json();
      alert(json.message);
      if (json.success) crearForm.reset();
    });
  }

  // Listar anuncios
  if (contenedor) {
    fetch("../api/anuncios/listar.php")
      .then((res) => res.json())
      .then((anuncios) => {
        contenedor.innerHTML = anuncios.length
          ? anuncios
              .map(
                (a) => `
              <div class="anuncio-card">
                <h3>${a.tipo_servicio} 🐾</h3>
                <p><strong>Inicio:</strong> ${a.fecha_inicio}</p>
                <p><strong>Precio:</strong> $${a.precio_total}</p>
                <p><strong>Notas:</strong> ${a.notas || "Sin notas"}</p>
                ${
                  !a.dueno_id
                    ? `<button class="btn-submit" data-id="${a.id}">Reservar</button>`
                    : ""
                }
              </div>`
              )
              .join("")
          : "<p>No hay anuncios disponibles</p>";
      });
  }

  // Reservar anuncio
  document.addEventListener("click", async (e) => {
    if (e.target.matches(".btn-submit[data-id]")) {
      const id = e.target.getAttribute("data-id");
      const res = await fetch("../api/anuncios/reservar.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id }),
      });
      const json = await res.json();
      alert(json.message);
      if (json.success) location.reload();
    }
  });
});

async function enviarFormulario(formId, alertId, redireccion = null) {
  const form = document.getElementById(formId);
  const alertBox = document.getElementById(alertId);
  const formData = new FormData(form);

  // Obtener la acción del formulario (el archivo PHP al que apunta)
  const url = form.getAttribute("action");

  try {
    const res = await fetch(url, {
      method: "POST",
      body: formData,
    });

    const data = await res.json();

    if (data.success) {
      alertBox.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
      form.reset();
      if (redireccion) {
        setTimeout(() => (window.location.href = redireccion), 1500);
      }
    } else {
      alertBox.innerHTML = `<div class="alert alert-error">${data.message}</div>`;
    }
  } catch (err) {
    alertBox.innerHTML = `<div class="alert alert-error">Error al conectar con el servidor.</div>`;
  }
}
