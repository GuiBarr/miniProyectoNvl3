<?php
// Iniciar sesión para verificar si el usuário está logado
session_start();

// Verificar si el usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Si no está él será redirigido a la página de login
    header('Location: index.php');
    exit();
}

// Conectarse a la base de dayos
require_once 'config\DB.php';

// Se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha as informações do usuário a partir do formulário
    $userId = $_SESSION['user_id'];
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];
    $newPassword = $_POST['new_password']; // Nova senha
    $newBio = $_POST['new_bio']; // Nova bio
    $newPhone = $_POST['new_phone']; // Novo telefone

    // Atualize as informações do usuário na base de dados
    $query = "UPDATE users SET name = :name, email = :email, contrasena = :contrasena, bio = :bio, phone = :phone WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $newName);
    $stmt->bindParam(':email', $newEmail);
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // Hashear a nova senha
    $stmt->bindParam(':contrasena', $hashedPassword);
    $stmt->bindParam(':bio', $newBio);
    $stmt->bindParam(':phone', $newPhone);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    // Redirecione para a página de informações pessoais após a atualização
    header('Location: personalInfo.php');
    exit();
}



// Obtener las informaciones actuales del usuário
$userId = $_SESSION['user_id'];
$query = "SELECT email, contrasena, photo, name, bio, phone  FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $userId);
$stmt->execute();
$userInfo = $stmt->fetch();
$userName = $userInfo['name'];
$userEmail = $userInfo['email'];
$userBio = $userInfo['bio'];
$userPhone = $userInfo['phone'];
$userPhoto = $userInfo['photo'];
$userContrasena = $userInfo['contrasena'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Informaciones</title>
    <!-- Adicione seus estilos CSS aqui -->
    <link rel="stylesheet" href="style\changeInfo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

</head>
<body>

    <div class="btn-back">
        <a href="personalInfo.php"> < Back </a>
    </div>

    <main class="main-edit">

    <header>

    <h1>Change Info</h1>
    <h4>Changes will be reflected to every services</h4>

    </header>

    <form class="form" action="changeInfo.php" method="post">
        <label class="titulo" for="new_name">Name:</label>
        <input class="input" type="text" name="new_name" id="new_name" value="<?php echo $userName; ?>" required>

        <label class="titulo" for="new_bio">Bio:</label>
        <textarea class="bio" name="new_bio" id="new_bio"><?php echo $userBio; ?></textarea>

        <label class="titulo" for="new_phone">Phone:</label>
        <input class="input" type="text" name="new_phone" id="new_phone" value="<?php echo $userPhone; ?>">

        <label class="titulo" for="new_email">Email:</label>
        <input class="input" type="email" name="new_email" id="new_email" value="<?php echo $userEmail; ?>" required>

        <label class="titulo" for="new_password">New Password:</label>
        <input class="input" type="password" name="new_password" id="new_password" required>

        <label class="titulo" for="confirm_password">Confirm Password:</label>
        <input class="input" type="password" name="confirm_password" id="confirm_password" required>

        <input class="btn-save" type="submit" value="Save">

    </form>

    </main>

    
</body>
</html>

