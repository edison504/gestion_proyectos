document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('productoForm');

    if (form) {
        form.addEventListener('submit', (e) => {
            const nombre = document.getElementById('nombre').value.trim();
            const categoria = document.getElementById('categoria_id').value;
            const precio = parseFloat(document.getElementById('precio').value);
            const cantidad = parseInt(document.getElementById('cantidad').value);

            if (!nombre) {
                alert('El nombre del producto/servicio es obligatorio.');
                e.preventDefault();
                return;
            }

            if (!categoria) {
                alert('Debe seleccionar una categoría.');
                e.preventDefault();
                return;
            }

            if (isNaN(precio) || precio <= 0) {
                alert('El precio debe ser un número mayor a 0.');
                e.preventDefault();
                return;
            }

            if (isNaN(cantidad) || cantidad < 0) {
                alert('La cantidad debe ser un número mayor o igual a 0.');
                e.preventDefault();
                return;
            }
        });
    }
});