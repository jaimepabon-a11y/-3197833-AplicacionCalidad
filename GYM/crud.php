<?php
// GYM/GYM/crud.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
require "db.php"; 

try {
    $sql_productos = "
        SELECT 
            p.id, p.nombre_producto, p.descripcion, p.precio, p.stock, c.nombre_categoria
        FROM 
            productos p
        JOIN 
            t_prod c ON p.categoria_id = c.id
        ORDER BY p.id ASC
    ";
    $stmt = $pdo->query($sql_productos);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Lectura (SELECT) de categorías para el formulario
    $stmt_cat = $pdo->query("SELECT id, nombre_categoria FROM t_prod ORDER BY nombre_categoria ASC");
    $categorias = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de Base de Datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>CRUD Productos</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4; /* Fondo gris claro */
    color: #333; /* Texto principal oscuro */
    padding: 20px;
}
.container {
    width: 95%; 
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

/* --- Formulario --- */
.form-section h3 { color: #555; margin-top: 20px; }
.form-group {
    margin-bottom: 10px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}
input[type="text"], input[type="number"], textarea, select {
    width: 100%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    background: #fff;
    color: #333;
    box-sizing: border-box;
}

.btn-primary, .btn-action, .btn-secondary {
    padding: 8px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: background 0.2s;
    display: inline-block;
}
.btn-primary { 
    background: red; 
    color: white; 
    margin-top: 10px;
}
.btn-primary:hover { background: #00FFFF; }

.btn-action { 
    font-size: 0.8em;
    padding: 5px 10px;
    margin-right: 5px;
}
.btn-action.edit { 
    background: #19b6ffff; 
    color: black;
}
.btn-action.delete { 
    background: #d9534f; 
    color: white;
}
.btn-action.edit:hover { background: #e09733; }
.btn-action.delete:hover { background: #00FFFF; } /*color boton editar */

.btn-secondary {
    background: #6c757d;        
    color: white;
    margin-top: 20px;
}
.btn-secondary:hover { background: #5a6268; }

/* --- Tabla --- */
.table-section h3 { color: red; margin-top: 30px;}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    border: 1px solid #ddd; 
}
th, td {
    padding: 12px 10px;
    text-align: left;
    border: none;
    border-bottom: 1px solid #eee; 
}
th { 
    background: #f0f0f0; 
    color: #333; 
    text-transform: uppercase;
    font-size: 0.9em;
    font-weight: bold;
}
tr:nth-child(even) { background: #fafafa; } 
tr:nth-child(odd) { background: white; } 
tr:hover { background: #e9ecef; }

</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Gestión de Productos</h1>
    </div>

    <?php 

    if (isset($_GET['status'])) {

        $msg = '';

        if ($_GET['status'] == 'added') {
            $msg = 'Producto agregado exitosamente.';
        } // Llave de cierre añadida

        if ($_GET['status'] == 'updated') {
            $msg = 'Producto actualizado exitosamente.';
        } // Llave de cierre añadida

        if ($_GET['status'] == 'deleted') {
            $msg = 'Producto eliminado exitosamente.';
        } // Llave de cierre añadida

        echo "<p class='status-msg' style='background-color:#28a745; color:white; padding:10px; border-radius:4px; margin-bottom:15px;'>$msg</p>";

    }

?>

    <div class="form-section">
        <h3>Añadir Nuevo Producto</h3>
        <form action="agregar_producto.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre_producto" placeholder=>
            </div>
            <div class="form-group">
                <label for="desc">Descripción:</label>
                <textarea id="desc" name="descripcion" placeholder=></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder=>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" placeholder=>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria_id" required>
                    <option value="">Selecciona Categoría</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id']; ?>">
                            <?= htmlspecialchars($cat['nombre_categoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn-primary">Agregar Producto</button>
        </form>
    </div>

    <div class="table-section">
        <h3>Lista de Productos</h3>
        <table> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']); ?></td>
                    <td><?= htmlspecialchars($row['nombre_producto']); ?></td>
                    <td>$<?= htmlspecialchars(number_format($row['precio'], 0, ',', '.')); ?></td>
                    <td><?= htmlspecialchars($row['stock']); ?></td> 
                    <td><?= htmlspecialchars($row['nombre_categoria']); ?></td> 
                    <td>
                        <a href="editar_producto.php?id=<?= $row['id']; ?>" class="btn-action edit">Editar</a>
                        <a href="eliminar_producto.php?id=<?= $row['id']; ?>" class="btn-action delete"
                           onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                            Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <br><a href="dashboard.php" class="btn-secondary">Volver al Dashboard</a>
</div>
</body>
</html>
