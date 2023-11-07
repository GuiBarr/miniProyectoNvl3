<?php
//iniciar sesión
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //conectarse a la base de datos
    require 'login_db';

    //obtener el email y contraseña del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    //consultar la database para obtener las credenciales del user
    $query = "SELECT Id, Email, Contrasena, Name FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    //Verificar si el user existe y la contraseña es correcta
    if($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];

        //Redirigir el usuario a la pagina de perfil
        header('Location: personalInfo.php');
        exit();
    } else {
        $error_message = "Credenciales invalidas. Intentelo nuevamente.";
    }
}
?>