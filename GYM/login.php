<?php
// GYM/GYM/login.php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    // Credenciales: admin / 1234
    if ($user == 'admin' && $pass == '1234') {
        $_SESSION['loggedin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Login GYM</title>
<style>

body {
    font-family: Arial, sans-serif;
    background: #f4f4f4; 
    color: #333; 
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.login-box {
    background: white; 
    padding: 30px;
    width: 450px; 
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
    text-align: center;
}
.login-box h2 {
    color: red;
    margin-top: 0;
    margin-bottom: 20px;
}
.input-group {
    margin-bottom: 15px;
}
input {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc; 
    background: #fff;
    color: #333;
    box-sizing: border-box; 
}
.btn-primary {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border: none;
    border-radius: 4px;
    background: blue;
    color: white;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.2s;
}
.btn-primary:hover { 
    background: #00FFFF; 
}
.error-msg {
    background: #00FFFF; 
    color: #00FFFF; 
    border: 1px solid #00FFFF;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}
</style>
</head>
<body>
<div class="login-box">
    <h2>Inicio de Sesión</h2>
    <?php if (isset($error)) echo "<p class='error-msg'>$error</p>"; ?>
    <form method="POST">
        <div class="input-group">
            <input type="text" id="user" name="user" >
        </div>
        <div class="input-group">
            <input type="password" id="pass" name="pass" placeholder=>
        </div>
        <button type="submit" class="btn-primary">Entrar</button>
    </form>
</div>  
</body>
</html>