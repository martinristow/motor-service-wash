<?php
require_once "inc/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/services_style.css"><!--Vcituvanje na css -->
    
</head>
<body>
    <header>
        <h1>Услуги</h1>
    </header>

    <div class="container">
        <div class="product-container">
           
            <div class="product">
               
                <form method="post" action="selected_service.php">
                    <input type="hidden" name="service_id" value="1">
                    <input type="hidden" name="service_name" value="Перење">
                    <button type="submit" name="submit_service">
                        <img src="public/images/car wash.jpg" alt="Product 1">
                    </button>
                </form>
                <div class="product-title">Перење</div>
            </div>

            <div class="product">
               
                <form method="post" action="selected_service.php">
                    <input type="hidden" name="service_id" value="2"> 
                    <input type="hidden" name="service_name" value="Сервис">
                    <button type="submit" name="submit_service">
                        <img src="public/images/car service.jpg" alt="Product 2">
                    </button>
                </form>
                <div class="product-title">Сервис</div>
            </div>
        </div>
    </div>
</body>
</html>
<?php require_once 'inc/footer.php'; ?>
