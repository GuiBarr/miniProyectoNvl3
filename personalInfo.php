<?php 
//iniciar sesión para verificar si el usuario está logado
session_start();

//verificar si el usuario está logado
if(!isset($_SESSION['user_id'])) {
    // si no está logado, es redirigido a la pagina de login
    header('Location: index.php');
    exit();
}

//si está logado, se le muestra sus informaciones
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Info</title>


</head>
<body>
    
    <h3>Profile</h1>

    <a href="changeInfo.php">Edit</a>
    
    <h4>PHOTO</h4>
    <h4>NAME <?php echo $userName; ?></h4>
    <h4>BIO</h4>
    <h4>PHONE</h4>
    <h4>EMAIL <?php echo $userEmail; ?></h4>
    <h4>PASSWORD</h4>

    <a href="logout.php">Logout</a>

</body>
</html>