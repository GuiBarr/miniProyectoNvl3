<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- add os estilos css aqui -->
    <link rel="stylesheet" href="style\index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

</head>
<body>
    
    <main class="main-login">

    <header>

    <img src="assets\devchallenges.svg" alt="devchallenges Icon" width="" height="">

    <h1>Login</h1>

    <form class="formulario" action="login.php" method="post">
    <label for="email"></label>
    <input class="inputs" type="email" name="email" id="email" placeholder="Email" required><br><br>

    <label for="password"></label>
    <input class="inputs" type="password" name="password" id="password" placeholder="Password" required><br><br>

    <input class="button-login" type="submit" value="Login">
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

    <h4>Don't have an account yet? <a href="register.php">Register</a></h4>

    </section>

    </main>

</body>
</html>