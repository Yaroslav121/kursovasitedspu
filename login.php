<?php
include 'db.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Clients WHERE email = '$email' AND password = '".md5($password)."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['client_id'];
        header("Location: index.php");
        exit();
    } else {
        $message = '<p class="message error">Неправильний логін або пароль.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Увійти</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h2>Увійти</h2>
        <?= $message ?? '' ?>
        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="Електронна пошта" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="login">Увійти</button>
            <p>Або <a href="register.php">зареєструйтесь</a>, якщо ще не маєте акаунту.</p>
        </form>
    </main>
</body>
</html>
