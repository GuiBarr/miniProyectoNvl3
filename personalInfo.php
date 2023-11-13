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
    <link rel="stylesheet" href="style\personalInfo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">



</head>
<body>

    <header>
        <h1>Personal info</h1>
        <h4>Basic info, like your name and photo</h4>
    </header>

    <main class="personal-info">

    <section class="sup-radius">
        <div class="profile">
            <h3>Profile</h3>
            <h5>Some info may be visible to other people</h5>
        </div>
        <div>
            <a class="btn-edit" href="changeInfo.php">Edit</a>
        </div>
    </section>

    <div class="rectangular2">
        <div class="titulo">PHOTO</div>
        <div class="profile-photo"><img src="<?php echo $userPhoto; ?>" alt="User Photo" width="100"></div>
    </div>

    <div class="rectangular">
        <div class="titulo">NAME</div>
        <div class="info" > <?php echo $userName; ?> </div>
    </div>

    <div class="rectangular2">
        <div class="titulo">BIO</div>
        <div class="info" > <?php echo $userBio; ?> </div>
    </div>

    <div class="rectangular">
        <div class="titulo">PHONE</div>
        <div class="info" > <?php echo $userPhone; ?> </div>
    </div>

    <div class="rectangular2">
        <div class="titulo">EMAIL</div>
        <div class="info" > <?php echo $userEmail; ?> </div>
    </div>

    <div class="inf-radius">
        <div class="titulo">PASSWORD</div>
        <div class="info" >*********</div>
    </div>

    </main>

    <footer>
    <a href="index.php">Back</a>
    <a class="logout" href="logout.php">Logout</a>    
    </footer>

</body>
</html>
