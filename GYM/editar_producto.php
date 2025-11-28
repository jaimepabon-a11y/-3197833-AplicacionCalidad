<?php
// GYM/GYM/editar_producto.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
require "db.php"; 

$id_producto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id_producto) {
    die("Error de Edición: ID de producto no válido. <a href='crud.php'>Volver</a>");
}

try {
    $sql_producto = "
        SELECT 
            p.id, p.nombre_producto, p.descripcion, p.precio, p.stock, p.categoria_id
        FROM 
            productos p
        WHERE 
            p.id = :id_producto
    ";

    $stmt_producto = $pdo->prepare($sql_producto);
    $stmt_producto->execute([':id_producto' => $id_producto]);
    $producto = $stmt_producto->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        die("Error de Edición: Producto no encontrado en la base de datos. <a href='crud.php'>Volver</a>");
    }

    $stmt_cat = $pdo->query("SELECT id, nombre_categoria FROM t_prod ORDER BY nombre_categoria ASC");
    $categorias = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error de Base de Datos al cargar la edición: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Editar Producto: <?= htmlspecialchars($producto['nombre_producto']); ?></title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    color: #333;
    padding: 20px;
}
.container {
    width: 95%; 
    max-width: 1000px;
    margin: 20px;
    
    background: white; 
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
.header h1 { 
    color: red; 
    margin-top: 0;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.form-group {
    margin-bottom: 15px;
    display: flex; 
    align-items: flex-start;
    gap: 20px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
    width: 120px; 
    flex-shrink: 0;
    padding-top: 10px;
    font-weight: bold;
    color: #333;
}
.form-group .input-container {
    flex-grow: 1;
}
input[type="text"], input[type="number"], textarea, select {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    background: #fff;
    color: #333;
    box-sizing: border-box;
}
textarea { resize: vertical; }

/* --- Botones --- */
.btn-primary, .btn-secondary {
    padding: 10px 18px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: background 0.2s;
    display: inline-block;
    margin-right: 10px;
}
.btn-primary { 
    background: red; 
    color: white; 
    margin-top: 10px;
}
.btn-primary:hover { background: #cc0000; }
.btn-secondary {
    background: #6c757d;
    color: white;
}
.btn-secondary:hover { background: #5a6268; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Editar Producto: <?= htmlspecialchars($producto['nombre_producto']); ?></h1>
    </div>
    
    <form action="actualizar_producto.php" method="POST">
        
        <input type="hidden" name="id" value="<?= $producto['id']; ?>">
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <div class="input-container">
                <input type="text" id="nombre" name="nombre_producto" 
                       value="<?= htmlspecialchars($producto['nombre_producto']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="desc">Descripción:</label>
            <div class="input-container">
                <textarea id="desc" name="descripcion" rows="3" required><?= htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <div class="input-container">
                <input type="number" id="precio" name="precio" required min="0"
                       value="<?= htmlspecialchars($producto['precio']); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <div class="input-container">
                <input type="number" id="stock" name="stock" required min="0"
                       value="<?= htmlspecialchars($producto['stock']); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <div class="input-container">
                <select id="categoria" name="categoria_id" required>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id']; ?>" 
                            <?= ($cat['id'] == $producto['categoria_id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($cat['nombre_categoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn-primary">Guardar Cambios</button>
        <a href="crud.php" class="btn-secondary">Cancelar y Volver</a>
    </form>
</div>
</body>
</html>