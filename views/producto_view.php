<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proyectos y Servicios</title>
    <link rel="stylesheet" href="public/css/style.css?v=10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <h1>Sistema de Gestión de Proyectos y Servicios</h1>
    </header>

    <main class="container">
        <section class="table-section">
            <div class="section-top">
                <h2>Listado de Productos / Servicios</h2>
                <button class="btn btn-primary" id="btnNuevo">+ Nuevo Producto</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $item): ?>
                            <tr>
                                <td><?= $item['id'] ?></td>
                                <td><?= htmlspecialchars($item['nombre']) ?></td>
                                <td><span class="badge"><?= htmlspecialchars($item['categoria_nombre']) ?></span></td>
                                <td>$<?= number_format($item['precio'], 2) ?></td>
                                <td><?= $item['cantidad'] ?></td>
                                <td class="td-desc"><?= htmlspecialchars($item['descripcion']) ?></td>
                                <td>
                                    <a href="index.php?action=editar&id=<?= $item['id'] ?>" class="btn-sm btn-edit">Editar</a>
                                    <a href="index.php?action=eliminar&id=<?= $item['id'] ?>" class="btn-sm btn-delete" onclick="confirmarEliminar(event, this.href)">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No hay registros almacenados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <div class="modal-overlay" id="confirmModal">
        <div class="modal-card confirm-card">
            <div class="confirm-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </div>
            <h3 class="confirm-title">¿Eliminar registro?</h3>
            <p class="confirm-desc">Esta acción no se puede deshacer. El registro se eliminará de forma permanente.</p>
            <div class="confirm-actions">
                <button class="btn btn-secondary" id="confirmCancel">Cancelar</button>
                <a href="#" class="btn btn-danger" id="confirmOk">Sí, eliminar</a>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-card">
            <div class="modal-header">
                <h2><?= $productoEditar ? 'Editar Registro' : 'Nuevo Producto' ?></h2>
                <a href="index.php" class="modal-close" id="modalClose">&#x2715;</a>
            </div>

            <form id="productoForm" action="index.php?action=guardar" method="POST">
                <input type="hidden" name="id" value="<?= $productoEditar['id'] ?? '' ?>">

                <div class="form-group">
                    <label for="nombre">Nombre del Producto/Servicio</label>
                    <input type="text" id="nombre" name="nombre" value="<?= $productoEditar['nombre'] ?? '' ?>" placeholder="Ej. Laptop Lenovo">
                    <span class="field-error" id="error-nombre"></span>
                </div>

                <div class="form-group">
                    <label for="categoria_id">Categoría</label>
                    <select id="categoria_id" name="categoria_id">
                        <option value="">-- Seleccione una categoría --</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($productoEditar) && $productoEditar['categoria_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="field-error" id="error-categoria"></span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="precio">Precio ($)</label>
                        <input type="number" step="0.01" id="precio" name="precio" value="<?= $productoEditar['precio'] ?? '' ?>" placeholder="0.00">
                        <span class="field-error" id="error-precio"></span>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad / Disponibilidad</label>
                        <input type="number" id="cantidad" name="cantidad" value="<?= $productoEditar['cantidad'] ?? '' ?>" placeholder="0">
                        <span class="field-error" id="error-cantidad"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="3" placeholder="Descripción del producto o servicio..."><?= $productoEditar['descripcion'] ?? '' ?></textarea>
                </div>

                <div class="form-actions">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary"><?= $productoEditar ? 'Actualizar' : 'Guardar' ?></button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 - Programación Web II | Uniremington</p>
    </footer>

    <script src="public/js/main.js"></script>
    <script>
        const overlay  = document.getElementById('modalOverlay');
        const btnNuevo = document.getElementById('btnNuevo');
        const btnClose = document.getElementById('modalClose');

        function openModal()  { overlay.classList.add('active'); }
        function closeModal() { overlay.classList.remove('active'); }

        btnNuevo.addEventListener('click', openModal);

        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeModal();
        });

        <?php if ($productoEditar): ?>
        openModal();
        <?php endif; ?>
    </script>
</body>
</html>
