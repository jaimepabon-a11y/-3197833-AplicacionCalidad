<?php
// GYM/GYM/dashboard.php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Dashboard GYM</title>
<style>

body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    color: #333;
    padding: 20px;
}
.container {
    width: 95%; 
    max-width: 1200px; 
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
.btn-group a {
    background: red;
    color: white;
    padding: 10px 18px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    margin-right: 15px;
    transition: background 0.2s;
    display: inline-block;
}
.btn-group a:hover { 
    background: #00FFFF; 
}
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Panel de Control</h1>
    </div>
    
    <p style="margin-bottom: 25px;">Selecciona una opción de gestión:</p>
    
    <div class="btn-group">
        <a href="crud.php">CRUD Productos</a> 
        <a href="agregar_categoria.php">Agregar Categoría</a> 
        <a href="logout.php">Cerrar sesión</a>
    </div>
</div>
</body>
</html>