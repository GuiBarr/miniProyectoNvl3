<?php
// Iniciar sesión para verificar si el usuario está logado
session_start();

// Verificar si el usuario está logado
if (!isset($_SESSION['user_id'])) {
    // Si no está logado, es redirigido a la página de login
    header('Location: index.php');
    exit();
}

// Conectarse a la base de datos
require_once 'config/DB.php';

// Obtener las informaciones actuales del usuario, incluyendo las nuevas columnas
$userId = $_SESSION['user_id'];
$query = "SELECT name, email, bio, phone, photo, contrasena FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $userId);
$stmt->execute();
$userInfo = $stmt->fetch();
$userName = $userInfo['name'];
$userEmail = $userInfo['email'];
$userBio = $userInfo['bio'];
$userPhone = $userInfo['phone'];
$userPhoto = $userInfo['photo'];
$userContrasena = $userInfo['contrasena']
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Info</title>
</head>
<body>
    <h3>Profile</h3>

    <a href="changeInfo.php">Edit</a>
    
    <h4>PHOTO</h4>
    <!-- Exibir a foto do usuário -->
    <img src="<?php echo $userPhoto; ?>" alt="User Photo" width="100">
    
    <h4>NAME: <?php echo $userName; ?></h4>
    <h4>BIO: <?php echo $userBio; ?></h4>
    <h4>PHONE: <?php echo $userPhone; ?></h4>
    <h4>EMAIL: <?php echo $userEmail; ?></h4>
    <h4>PASSWORD: ***********</h4>

    <a href="logout.php">Logout</a>
</body>
</html>
