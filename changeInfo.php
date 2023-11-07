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
require 'DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener las informaciones del usuário a partir del formulário
    $userId = $_SESSION['user_id'];
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];

    // Actualize las informaciones del usuário en la base de datos
    $query = "UPDATE users SET name = :name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $newName);
    $stmt->bindParam(':email', $newEmail);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    // Redirigir para la página de informaciones personales después de la actualización
    header('Location: personalInfo.php');
    exit();
}

// Obtener las informaciones actuales del usuário
$userId = $_SESSION['user_id'];
$query = "SELECT name, email FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $userId);
$stmt->execute();
$userInfo = $stmt->fetch();
$userName = $userInfo['name'];
$userEmail = $userInfo['email'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Informaciones</title>
    <!-- Adicione seus estilos CSS aqui -->
</head>
<body>
    <h1>Change Info</h1>
    <form action="change_info.php" method="post">
        <label for="new_name">Name:</label>
        <input type="text" name="new_name" id="new_name" value="<?php echo $userName; ?>" required><br><br>

        <label for="new_email">Email:</label>
        <input type="email" name="new_email" id="new_email" value="<?php echo $userEmail; ?>" required><br><br>

        <input type="submit" value="Save">
    </form>

    <a href="personal_info.php">Regresar</a>
</body>
</html>
