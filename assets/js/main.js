document.addEventListener("DOMContentLoaded", () => {
  const crearForm = document.getElementById("form-crear-anuncio");
  const contenedor = document.getElementById("anuncios-container");

  let anunciosOriginales = [];

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
    cargarAnuncios();
  }

  async function cargarAnuncios() {
    const res = await fetch("../api/anuncios/listar.php");
    let data = await res.json();

    const ahora = new Date();

    // Si es cuidador → ver todo
    if (window.tipoUsuario === "cuidador") {
      anunciosOriginales = data;
    } else {
      // Si es dueño → ver solo los no vencidos
      anunciosOriginales = data.filter((a) => {
        if (
          !a.fecha_fin ||
          (a.fecha_fin === "0000-00-00 00:00:00" &&
            new Date(a.fecha_inicio) > ahora)
        )
          return true;
        return (
          new Date(a.fecha_fin) < ahora && new Date(a.fecha_inicio) > ahora
        );
      });
    }

    aplicarFiltros();
  }

  function aplicarFiltros() {
    const filtroServicio =
      document.getElementById("filtro-servicio")?.value || "";
    const filtroPrecioMin =
      parseFloat(document.getElementById("filtro-precio-min")?.value) || 0;
    const filtroPrecioMax =
      parseFloat(document.getElementById("filtro-precio-max")?.value) ||
      Infinity;
    const filtroFecha = document.getElementById("filtro-fecha")?.value || "";
    const ordenar =
      document.getElementById("filtro-ordenar")?.value || "fecha-desc";

    let anunciosFiltrados = anunciosOriginales.filter((a) => {
      const cumpleServicio =
        !filtroServicio || a.tipo_servicio === filtroServicio;
      const cumplePrecio =
        parseFloat(a.precio_total) >= filtroPrecioMin &&
        parseFloat(a.precio_total) <= filtroPrecioMax;
      const fechaAnuncio = a.fecha_inicio.split(" ")[0];
      const cumpleFecha = !filtroFecha || fechaAnuncio === filtroFecha;

      return cumpleServicio && cumplePrecio && cumpleFecha;
    });

    // Ordenar
    anunciosFiltrados.sort((a, b) => {
      switch (ordenar) {
        case "fecha-asc":
          return new Date(a.fecha_inicio) - new Date(b.fecha_inicio);
        case "fecha-desc":
          return new Date(b.fecha_inicio) - new Date(a.fecha_inicio);
        case "precio-asc":
          return parseFloat(a.precio_total) - parseFloat(b.precio_total);
        case "precio-desc":
          return parseFloat(b.precio_total) - parseFloat(a.precio_total);
        default:
          return 0;
      }
    });

    mostrarAnuncios(anunciosFiltrados);
  }

  function mostrarAnuncios(anuncios) {
    contenedor.innerHTML = anuncios.length
      ? anuncios
          .map(
            (a) => `
      <div class="anuncio-card">
        <h3>${a.tipo_servicio}</h3>
        <p><strong>Inicio:</strong> ${a.fecha_inicio}</p>
        <p><strong>Fin:</strong> ${a.fecha_fin ?? "No definido"}</p>
        <p><strong>Precio:</strong> $${parseFloat(a.precio_total).toFixed(
          2
        )}</p>
        <p><strong>Notas:</strong> ${a.notas || "Sin notas"}</p>

        ${
          window.tipoUsuario === "cuidador"
            ? `<button class="btn-delete" data-delete="${a.id}">Eliminar</button>`
            : ""
        }

      </div>`
          )
          .join("")
      : "<p>No hay anuncios que coincidan con los filtros</p>";
  }

  document.addEventListener("click", async (e) => {
    if (e.target.matches(".btn-delete[data-delete]")) {
      if (!confirm("¿Seguro que deseas eliminar este anuncio?")) return;

      const id = e.target.getAttribute("data-delete");

      const res = await fetch("../api/anuncios/eliminar.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id }),
      });

      const json = await res.json();
      alert(json.message);
      if (json.success) cargarAnuncios();
    }
  });

  // Event listeners para filtros
  const filtros = [
    "filtro-servicio",
    "filtro-precio-min",
    "filtro-precio-max",
    "filtro-fecha",
    "filtro-ordenar",
  ];
  filtros.forEach((id) => {
    const elemento = document.getElementById(id);
    if (elemento) {
      elemento.addEventListener("change", aplicarFiltros);
      elemento.addEventListener("input", aplicarFiltros);
    }
  });

  // Limpiar filtros
  const btnLimpiar = document.getElementById("btn-limpiar-filtros");
  if (btnLimpiar) {
    btnLimpiar.addEventListener("click", () => {
      document.getElementById("filtro-servicio").value = "";
      document.getElementById("filtro-precio-min").value = "";
      document.getElementById("filtro-precio-max").value = "";
      document.getElementById("filtro-fecha").value = "";
      document.getElementById("filtro-ordenar").value = "fecha-desc";
      aplicarFiltros();
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
      if (json.success) cargarAnuncios();
    }
  });
});

document.addEventListener("click", async (e) => {
  if (e.target.matches(".btn-cancelar")) {
    const id = e.target.getAttribute("data-id");

    if (!confirm("¿Seguro que deseas cancelar esta reserva?")) return;

    const res = await fetch("../api/reservas/cancelar.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id }),
    });

    const json = await res.json();
    alert(json.message);

    if (json.success) location.reload();
  }
});

async function enviarFormulario(formId, alertId, redireccion = null) {
  const form = document.getElementById(formId);
  const alertBox = document.getElementById(alertId);
  const formData = new FormData(form);

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
