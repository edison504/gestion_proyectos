<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proyectos y Servicios</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <header>
        <h1>Sistema de Gestión de Proyectos y Servicios</h1>
    </header>

    <main class="container">
        <!-- Formulario de Registro / Edición -->
        <section class="form-section">
            <h2><?= $productoEditar ? 'Editar Registro' : 'Nuevo Registro' ?></h2>
            <form id="productoForm" action="index.php?action=guardar" method="POST">
                <input type="hidden" name="id" value="<?= $productoEditar['id'] ?? '' ?>">

                <div class="form-group">
                    <label for="nombre">Nombre del Producto/Servicio:</label>
                    <input type="text" id="nombre" name="nombre" value="<?= $productoEditar['nombre'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="categoria_id">Categoría:</label>
                    <select id="categoria_id" name="categoria_id">
                        <option value="">-- Seleccione una categoría --</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($productoEditar) && $productoEditar['categoria_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="precio">Precio ($):</label>
                    <input type="number" step="0.01" id="precio" name="precio" value="<?= $productoEditar['precio'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad / Disponibilidad:</label>
                    <input type="number" id="cantidad" name="cantidad" value="<?= $productoEditar['cantidad'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="3"><?= $productoEditar['descripcion'] ?? '' ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><?= $productoEditar ? 'Actualizar' : 'Guardar' ?></button>
                <?php if ($productoEditar): ?>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </form>
        </section>

        <!-- Tabla de Registros -->
        <section class="table-section">
            <h2>Listado de Productos / Servicios</h2>
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
                                <td><?= htmlspecialchars($item['descripcion']) ?></td>
                                <td>
                                    <a href="index.php?action=editar&id=<?= $item['id'] ?>" class="btn-sm btn-edit">Editar</a>
                                    <a href="index.php?action=eliminar&id=<?= $item['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('¿Seguro que deseas eliminar este registro?')">Eliminar</a>
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

    <footer>
        <p>&copy; 2026 - Programación Web II | Uniremington</p>
    </footer>

    <script src="public/js/main.js"></script>
</body>
</html>