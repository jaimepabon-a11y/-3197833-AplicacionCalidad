<?php
// GYM/GYM/eliminar_producto.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

require "db.php"; 

$id_producto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id_producto === false || $id_producto === null) {
    die("Error de Eliminación: ID de producto inválido o no proporcionado.");
}

try {
    $sql = "DELETE FROM productos WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([':id' => $id_producto]);

    header("Location: crud.php?status=deleted");
    exit;

} catch (PDOException $e) {
    echo "Error al eliminar el producto (PDO): " . $e->getMessage();
    exit;
}
?>