<?php
require '../app/config/config.php';
require '../app/classes/User.php';

$update_id = isset($_GET['update_id']) ? $_GET['update_id'] : '';

// ako update_id ne e zemen togas vrni go nazad
if ($update_id === '') {
    header("Location: test.php");
    exit();
}

// se zimat podatocite od html formata 
$run = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $service_id = $_POST['service_id'];

    $sql_update = "UPDATE services SET service_name = ?, description = ?, price = ? WHERE service_id = ?";//praveme update na uslugata
    $run = $conn->prepare($sql_update);
    $run->bind_param("ssii", $service_name, $description, $price, $service_id);

    // se izvrsuva samo ako e kliknato kopceto
    if ($run->execute()) {
        $success_message = "Услугата е успешно ажурирана.";
    } else {
        $error_message = "Грешка при ажурирање на Услугата: " . $run->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_admin/update_test_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Ажурирај услуги</title>
</head>
<body>
    <div class="container">
        <?php 
            $sql = "SELECT * FROM services WHERE service_id  = ?";
            $run_select = $conn->prepare($sql);
            $run_select->bind_param("i", $update_id);
            $run_select->execute();
            $result_select = $run_select->get_result();

            if ($result_select->num_rows > 0) {
                $row = $result_select->fetch_assoc();
        ?>
        <!-- forma za aziriranje na podatocite-->
        <form action="" method="post">
        <?php require "admin_header.php"; ?><!--Vcituvanje na header delot  -->
            <input type="hidden" name="service_id" value="<?php echo $update_id; ?>">
            <h2 style="color: #007bff;">Ажурирај услуга</h2>
            
            <label for="service_name">Внеси име на услугата</label>
            <input type="text" name="service_name" id="service_name" class="form-control" value="<?php echo $row['service_name']; ?>"><br>
           
            <label for="description">Внеси опис на услугата</label>
            <textarea name="description" id="description" cols="60" rows="5" class="form-control" placeholder="Vnesi опис на промоцијата"><?php echo $row['description']; ?></textarea><br>
            
            <label for="price">Внеси цена на услугата</label>
            <input type="number" name="price" id="price" class="form-control" value="<?php echo $row['price']; ?>"><br>

            <input type="submit" class="btn btn-success" value="Ažuriraj">
        </form>
        <?php
            if (isset($success_message)) {
                echo "<div class='alert alert-success'>$success_message</div>";
            } elseif (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
        } else {
            echo "Услугата не е пронајдена.";
        }
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
