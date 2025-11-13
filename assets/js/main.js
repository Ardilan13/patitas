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
