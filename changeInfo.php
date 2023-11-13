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
</head>
<body>
    <h1>Change Info</h1>
    <form action="changeInfo.php" method="post">
        <label for="new_name">Name:</label>
        <input type="text" name="new_name" id="new_name" value="<?php echo $userName; ?>" required><br><br>

        <label for="new_email">Email:</label>
        <input type="email" name="new_email" id="new_email" value="<?php echo $userEmail; ?>" required><br><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br><br>

        <label for="new_bio">Bio:</label>
        <textarea name="new_bio" id="new_bio"><?php echo $userBio; ?></textarea><br><br>

        <label for="new_phone">Phone:</label>
        <input type="text" name="new_phone" id="new_phone" value="<?php echo $userPhone; ?>"><br><br>

        <input type="submit" value="Save">
    </form>

    <a href="personalInfo.php">Regresar</a>
</body>
</html>

