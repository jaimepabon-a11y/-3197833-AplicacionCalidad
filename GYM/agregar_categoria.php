<?php
// GYM/GYM/agregar_categoria.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
require "db.php"; 

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_categoria = filter_input(INPUT_POST, 'nombre_categoria', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($nombre_categoria)) {
        $mensaje = "<p class='status-msg error'>El nombre de la categoría no puede estar vacío.</p>";
    } else {
        try {
            $sql = "INSERT INTO t_prod (nombre_categoria) VALUES (:nombre)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombre_categoria]);

            $mensaje = "<p class='status-msg success'>¡Categoría '<strong>" . htmlspecialchars($nombre_categoria) . "</strong>' agregada exitosamente!</p>";

        } catch (PDOException $e) {
            $mensaje = "<p class='status-msg error'>Error al agregar categoría: " . $e->getMessage() . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Agregar Categoría</title>
<style>
------------------------------------ */
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    color: #333;
    padding: 20px;
}
.container {
    width: 95%; 
    max-width: 900px;
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
    margin-bottom: 20px;
}
label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}
input[type="text"] {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    background: #fff;
    color: #333;
    box-sizing: border-box;
    max-width: 400px; 
}
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
}
.btn-primary:hover { background: #00FFFF; }
.btn-secondary {
    background: #6c757d;
    color: white;
}
.btn-secondary:hover { background: #5a6268; }

.status-msg {
    padding: 10px;
    border-radius: 4px;
    font-weight: bold;
    margin-bottom: 15px;
}
.status-msg.success {
    background: #d4edda; 
    color: #155724; 
    border: 1px solid #c3e6cb;
}
.status-msg.error {
    background: #f8d7da; 
    color: #00FFFF; 
    border: 1px solid #f5c6cb;
}
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Agregar Nueva Categoría</h1>
    </div>

    <?= $mensaje; ?>

    <form method="POST">
        <div class="form-group">
            <label for="nombre_categoria">Nombre de la Categoría:</label>
            <input type="text" id="nombre_categoria" name="nombre_categoria" required>
        </div>
        <button type="submit" class="btn-primary">Guardar Categoría</button>
        <a href="dashboard.php" class="btn-secondary">Volver al Dashboard</a>
    </form>
</div>
</body>
</html>