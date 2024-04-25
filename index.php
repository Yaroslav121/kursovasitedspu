<?php
include 'db.php';
session_start();

$sql = "SELECT * FROM Cars";
$result = $conn->query($sql);
$cars = $result->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submitOrder'])) {
    $client_id = $_SESSION['user_id'];
    $car_id = $_POST['carId'];
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];

    $sql = "SELECT model, license_plate FROM Cars WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $stmt->bind_result($model, $license_plate);
    $stmt->fetch();
    $stmt->close();

    $sql = "INSERT INTO Orders (client_id, car_id, pickup_location, dropoff_location, status) VALUES (?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $client_id, $car_id, $pickup, $dropoff);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Замовлення створено на автомобіль: $model, номерний знак: $license_plate.";
    } else {
        $_SESSION['error'] = "Помилка при створенні замовлення.";
    }
    $stmt->close();

    header("Location: index.php");
    exit();
}

$message = '';
if (isset($_SESSION['message'])) {
    $message = "<p class='message success'>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']);
} elseif (isset($_SESSION['error'])) {
    $message = "<p class='message error'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Таксі Онлайн</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Ласкаво просимо до Таксі Онлайн</h1>
        <nav>
            <ul>
                <li><a href="logout.php">Вийти</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Доступні автомобілі:</h2>
        <?php if ($message): ?>
        <div class="message-box">
            <?= $message ?>
            <span class="close-message">&times;</span>
        </div>
        <?php endif; ?>
        <ul>
            <?php foreach ($cars as $car): ?>
                <li>
                    <?= htmlspecialchars($car['model']) ?> - <?= htmlspecialchars($car['color']) ?>
                    (<?= htmlspecialchars($car['license_plate']) ?>) - 
                    Статус: <?= htmlspecialchars($car['car_status']) ?>
                    <?php if ($car['car_status'] === 'available'): ?>
                        <button class="button-order" onclick="orderCar(<?= $car['car_id'] ?>)">Замовити</button>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div id="orderModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Замовити автомобіль</h2>
                <form id="orderForm" method="post" action="">
                    <input type="hidden" id="carId" name="carId" value="">
                    <label for="pickup">Місце виїзду:</label>
                    <input type="text" id="pickup" name="pickup" required>
                    <label for="dropoff">Місце призначення:</label>
                    <input type="text" id="dropoff" name="dropoff" required>
                    <button type="submit" name="submitOrder">Підтвердити замовлення</button>
                </form>
            </div>
        </div>

    </main>

    <footer>
        <p>© 2024 Таксі Онлайн. Всі права захищені.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
