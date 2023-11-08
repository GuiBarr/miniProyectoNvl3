<?php

session_start();

// Verificar si el usuário está logado, si sí redirigirlo para la página de perfil
if (isset($_SESSION['user_id'])) {
    header('Location: personalInfo.php');
    exit();
}

// Conexión a la base de datos
require 'config\DB.php'; 

// Si el formulário de registro fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenga los datos del formulário
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];


    // Verifique se o email já está em uso
    $query = "SELECT id FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $error_message = "Este email ya existe. Elija otro.";
    } else {
        // Hash de contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insira o novo usuário no banco de dados
        $query = "INSERT INTO users (email, contrasena, name) VALUES (:email, :contrasena, :name)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasena', $hashedPassword);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        // Redirigir el usuário a la página de perfil
        header('Location: personalInfo.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <!-- Adicione seus estilos CSS aqui -->
</head>
<body>
    <h1>Registro</h1>
    
    <?php
    // Exiba uma mensagem de erro, se houver
    if (isset($error_message)) {
        echo "<p>$error_message</p>";
    }
    ?>

    <form action="register.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" required><br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>
