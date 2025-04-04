<div class="container">
    <h1>Gestión de Usuarios</h1>
    <a href="index.php?action=register" class="btn btn-danger">Añadir usuario</a>
    <?php if (!empty($usuarios)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                        <td><?= htmlspecialchars($usuario['correo']) ?></td>
                        <td>
                            <form action="index.php?action=usuarios_admin" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="eliminar_usuario">
                                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario'] ?? '') ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay usuarios registradas en este momento.</p>
    <?php endif; ?>
</div>