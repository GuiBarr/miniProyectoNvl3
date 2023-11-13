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
        $query = "INSERT INTO users (email, contrasena) VALUES (:email, :contrasena)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasena', $hashedPassword);
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
    <link rel="stylesheet" href="style\register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">


</head>
<body>

    <main class="main-login">

    <header>

    <img src="assets\devchallenges.svg" alt="devchallenes Icon" width="" height="">

    <h1>Join thousands of learners from<br> around the world</h1>
    <h3>Master web development by making real-life<br> projects.
    There are multiple paths for you to choose.</h3>

<?php
if (isset($error_message)) {
    echo "<p>$error_message</p>";
}
?>

    <form class="formulario" action="register.php" method="post">
        <label for="email"></label>
        <input class="inputs" type="email" name="email" id="email" placeholder="Email" required><br><br>

        <label for="password"></label>
        <input class="inputs" type="password" name="password" id="password" placeholder="Password" required><br><br>

        <input class="btn-submit" type="submit" value="Start coding now">
    </form>

    </header>

    <section>

    <h4>or continue with these social profile</h4>

    <div class="images">
        <img src="assets\Google.svg" alt="Google Icon" width="" height="">
        <img src="assets\Facebook.svg" alt="Facebook Icon" width="" height="">
        <img src="assets\Twitter.svg" alt="Twitter Icon" width="" height="">
        <img src="assets\Gihub.svg" alt="Github Icon" width="" height="">
    </div>

    <h4>Already a member? <a href="index.php">Login</a></h4>

    </section>

    </main>
</body>
</html>
