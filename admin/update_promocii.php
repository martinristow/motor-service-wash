<?php
require '../app/config/config.php';
require '../app/classes/User.php';

$update_id = isset($_GET['update_id']) ? $_GET['update_id'] : '';

// ako update_id ne e zemen togas vrni go nazad
if ($update_id === '') {
    header("Location: update_promocii.php");
    exit();
}
// se obrabotuvaat podatocite od html formata
$run = null; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $promotion_name = $_POST['promotion_name'];
    $description = $_POST['description'];
    $discount_percentage = $_POST['discount_percentage'];
    $promotion_id = $_POST['promotion_id'];

    $sql_update = "UPDATE promotions SET promotion_name = ?, description = ?, discount_percentage = ? WHERE promotion_id = ?";
    $run = $conn->prepare($sql_update);
    $run->bind_param("ssii", $promotion_name, $description, $discount_percentage, $promotion_id);

    if ($run->execute()) {
        $success_message = "Промоцијата е успешно ажурирана.";
    } else {
        $error_message = "Грешка при ажурирање на промоцијата: " . $run->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_admin/update_promocii_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Ажурирај промоција</title>
</head>
<body>
    <div class="container">
        <?php 
            $sql = "SELECT * FROM promotions WHERE promotion_id = ?";
            $run_select = $conn->prepare($sql);
            $run_select->bind_param("i", $update_id);
            $run_select->execute();
            $result_select = $run_select->get_result();

            if ($result_select->num_rows > 0) {
                $row = $result_select->fetch_assoc();
        ?>
       
        <form action="" method="post">
        <?php require "admin_header.php"; ?><!--Vcituvanje na header delot  -->
            <input type="hidden" name="promotion_id" value="<?php echo $update_id; ?>">
            <h2 style="color: #007bff;">Ажурирај промоција</h2>
            
            <label for="promotion_name">Внеси име на промоцијата</label>
            <input type="text" name="promotion_name" id="promotion_name" class="form-control" value="<?php echo $row['promotion_name']; ?>"><br>
           
            <label for="description">Внеси опис на промоцијата</label>
            <textarea name="description" id="description" cols="60" rows="5" class="form-control" placeholder="Vnesi опис на промоцијата"><?php echo $row['description']; ?></textarea><br>
            
            <label for="discount_percentage">Внеси цена на промоцијата</label>
            <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" value="<?php echo $row['discount_percentage']; ?>"><br>

           
            <input type="submit" class="btn btn-success" value="Ажурирај">
        </form>
        <?php
            if (isset($success_message)) {
                echo "<div class='alert alert-success'>$success_message</div>";
            } elseif (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
        } else {
            echo "Промоцијата не е пронајдена.";
        }
        ?>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
