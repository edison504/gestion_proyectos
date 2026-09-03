function showError(fieldId, errorId, msg) {
  document.getElementById(fieldId).classList.add("input-error");
  document.getElementById(errorId).textContent = msg;
}

function clearError(fieldId, errorId) {
  document.getElementById(fieldId).classList.remove("input-error");
  document.getElementById(errorId).textContent = "";
}

let deleteUrl = null;

function confirmarEliminar(e, url) {
  e.preventDefault();
  deleteUrl = url;
  document.getElementById("confirmModal").classList.add("active");
}

document.addEventListener("DOMContentLoaded", () => {
  if (sessionStorage.getItem("justCreated")) {
    sessionStorage.removeItem("justCreated");
    Swal.fire({
      icon: "success",
      title: "Producto creado",
      text: "El registro se creó de forma exitosa.",
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
  }

  if (sessionStorage.getItem("justUpdated")) {
    sessionStorage.removeItem("justUpdated");
    Swal.fire({
      icon: "success",
      title: "Producto actualizado",
      text: "El registro se actualizó de forma exitosa.",
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
  }

  if (sessionStorage.getItem("justDeleted")) {
    sessionStorage.removeItem("justDeleted");
    Swal.fire({
      icon: "success",
      title: "Registro eliminado",
      text: "El registro se eliminó de forma exitosa.",
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
  }

  const confirmModal  = document.getElementById("confirmModal");
  const confirmOk     = document.getElementById("confirmOk");
  const confirmCancel = document.getElementById("confirmCancel");

  confirmCancel.addEventListener("click", () => {
    confirmModal.classList.remove("active");
    deleteUrl = null;
  });
  confirmOk.addEventListener("click", () => {
    if (deleteUrl) {
      sessionStorage.setItem("justDeleted", "1");
      window.location.href = deleteUrl;
    }
  });
  confirmModal.addEventListener("click", (e) => {
    if (e.target === confirmModal) {
      confirmModal.classList.remove("active");
      deleteUrl = null;
    }
  });

  const form = document.getElementById("productoForm");
  if (!form) return;

  const fields = [
    { id: "nombre",       error: "error-nombre" },
    { id: "categoria_id", error: "error-categoria" },
    { id: "precio",       error: "error-precio" },
    { id: "cantidad",     error: "error-cantidad" },
  ];

  fields.forEach(({ id, error }) => {
    document.getElementById(id).addEventListener("input",  () => clearError(id, error));
    document.getElementById(id).addEventListener("change", () => clearError(id, error));
  });

  form.addEventListener("submit", (e) => {
    const nombre    = document.getElementById("nombre").value.trim();
    const categoria = document.getElementById("categoria_id").value;
    const precio    = parseFloat(document.getElementById("precio").value);
    const cantidad  = parseInt(document.getElementById("cantidad").value);

    let hasError = false;

    if (!nombre) {
      showError("nombre", "error-nombre", "El nombre es obligatorio.");
      hasError = true;
    }
    if (!categoria) {
      showError("categoria_id", "error-categoria", "Seleccione una categoría.");
      hasError = true;
    }
    if (isNaN(precio) || precio <= 0) {
      showError("precio", "error-precio", "El precio debe ser mayor a 0.");
      hasError = true;
    }
    if (isNaN(cantidad) || cantidad < 0) {
      showError("cantidad", "error-cantidad", "La cantidad debe ser 0 o mayor.");
      hasError = true;
    }

    if (hasError) {
      e.preventDefault();
    } else {
      const id = form.querySelector("input[name='id']").value;
      if (!id) sessionStorage.setItem("justCreated", "1");
      else     sessionStorage.setItem("justUpdated", "1");
    }
  });
});
