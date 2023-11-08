<?php
// Iniciar sesión
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar-se ao banco de dados
    require 'config\DB.php';

    // Obter o email e senha do formulário
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consultar o banco de dados para obter as credenciais do usuário
    $query = "SELECT id, email, contrasena, name FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    // Verificar se o usuário existe e a senha está correta
    if ($user && password_verify($password, $user['contrasena'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_bio'] = $user['bio'];
        $_SESSION['user_phone'] = $user['phone'];
        $_SESSION['user_photo'] = $user['photo'];

    

        // Redirecionar o usuário para a página de perfil
        header('Location: personalInfo.php');
        exit();
    } else {
        $error_message = "Credenciales inválidas. Inténtelo nuevamente.";
        header("Location: index.php");
    }
}
?>
