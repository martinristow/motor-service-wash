<?php require_once 'inc/header.php'; ?>
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $service_name = $_POST['service_name'];
    $price = $_POST['price'];

    $_SESSION['selected_service'] = $service_name;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Купувачка кошничка</title>
    <style>
    body {
    font-family: 'Arial', sans-serif;
    margin: 8px;
    padding: 0;
    background-color: #f8f9fa;
}

header {
    background-color: #111;
    color: #fff;
    text-align: center;
    padding: 1em;
}

.container {
    width: 100%;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.cart-item {
    margin-bottom: 20px;
    padding: 15px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.cart-item strong {
    color: #007bff;
}

.cart-item::after {
    content: "";
    display: table;
    clear: both;
}

    </style>
</head>
<body>
    <header>
        <h1>Кошничка</h1>
    </header>

    <div class="container">
        <h2>Твојата кошничка:</h2>

        <div class="cart-item">
            <strong>Услуга:</strong> <?php echo isset($_SESSION['selected_service']) ? $_SESSION['selected_service']  : 'No service selected'; ?><br>
        </div>
       
    </div>
</body>
</html>
<?php require_once 'inc/footer.php'; ?>