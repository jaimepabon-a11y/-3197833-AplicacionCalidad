<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
if (!isset($_SESSION['loggedin']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}


require "db.php"; 

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nombre_producto = filter_input(INPUT_POST, 'nombre_producto', FILTER_SANITIZE_SPECIAL_CHARS);
$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);

$precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT); 
$stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
$categoria_id = filter_input(INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT);

if (!$id || !$nombre_producto || !$descripcion || $precio === false || $stock === false || $categoria_id === false) {
    header("Location: crud.php?status=error&message=Datos incompletos o inválidos.");
    exit;
}

try {
    $sql = "UPDATE productos SET 
                nombre_producto = :nombre, 
                descripcion = :desc, 
                precio = :precio, 
                stock = :stock, 
                categoria_id = :cat_id
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $id,
        ':nombre' => $nombre_producto,
        ':desc' => $descripcion,
        ':precio' => $precio, 
        ':stock' => $stock,
        ':cat_id' => $categoria_id
    ]);

    header("Location: crud.php?status=updated");
    exit;

} catch (PDOException $e) {
    error_log("Error al actualizar el producto: " . $e->getMessage()); 
    header("Location: crud.php?status=error&message=Error en la base de datos.");
    exit;
}
?>
