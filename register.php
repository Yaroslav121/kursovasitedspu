<?php
include 'db.php';

if (isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = md5($_POST['password']);

    $sql = "INSERT INTO Clients (first_name, last_name, email, phone_number, password) VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$password')";
    if ($conn->query($sql) === TRUE) {
        $message = '<p class="message success">Реєстрація пройшла успішно!</p>';
    } else {
        $message = '<p class="message error">Помилка: ' . $conn->error . '</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Реєстрація</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h2>Реєстрація</h2>
        <?= $message ?? '' ?>
        <form action="register.php" method="post">
            <input type="text" name="first_name" placeholder="Ім'я" required>
            <input type="text" name="last_name" placeholder="Прізвище" required>
            <input type="email" name="email" placeholder="Електронна пошта" required>
            <input type="text" name="phone_number" placeholder="Телефон" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="register">Реєструватися</button>
            <p>Вже маєте акаунт? <a href="login.php">Увійти</a></p>
        </form>
    </main>
</body>
</html>
