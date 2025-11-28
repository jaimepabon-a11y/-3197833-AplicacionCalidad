<?php
// GYM/GYM/agregar_producto.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['loggedin']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

require "db.php"; 

$nombre_producto = filter_input(INPUT_POST, 'nombre_producto', FILTER_SANITIZE_SPECIAL_CHARS);
$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
$precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_INT);
$stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
$categoria_id = filter_input(INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT);

if (!$nombre_producto || !$descripcion || $precio === false || $stock === false || $categoria_id === false) {
    die("Error: Datos de producto incompletos o inválidos. Vuelve a <a href='crud.php'>CRUD</a>");
}

try {
    $sql = "INSERT INTO productos (nombre_producto, descripcion, precio, stock, categoria_id) 
            VALUES (:nombre, :desc, :precio, :stock, :cat_id)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nombre' => $nombre_producto,
        ':desc' => $descripcion,
        ':precio' => $precio,
        ':stock' => $stock,
        ':cat_id' => $categoria_id
    ]);

    header("Location: crud.php?status=added");
    exit;

} catch (PDOException $e) {
    // Esto es útil si tienes errores de base de datos o de clave foránea.
    echo "Error al agregar el producto: " . $e->getMessage();
    exit;
}
?>