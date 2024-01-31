<?php
require '../app/config/config.php';
require '../app/classes/User.php';

$update_id = isset($_GET['update_id']) ? $_GET['update_id'] : '';

//dokolku id ne e zemeno togas vrni go na stranata koja sto e navedena vo header
if ($update_id === '') {
    header("Location: update_test.php");
    exit();
}

//gi zimame podatocite od formata
$run = null; // inicijalizacija na run so pocetna vrednost null
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $appointment_date = $_POST['appointment_date'];
    $status = $_POST['status'];
    $appointments_id  = $_POST['appointments_id'];

    $sql_update = "UPDATE appointments SET appointment_date = ? , status = ? WHERE appointments_id  = ?";//go updajtirame poleto so novite podatoci
    $run = $conn->prepare($sql_update);
    $run->bind_param("ssi",$appointment_date, $status, $appointments_id);

    //dokolku e kliknato kopceto da se izvrsi akcijata
    if ($run->execute()) {
        $success_message = "Терминот е успешно ажуриран.";
    } else {
        $error_message = "Грешка при ажурирање на терминот: " . $run->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_employee/update_termin_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Ажурирај термин</title>
</head>
<body>
    <div class="container">
        <?php 
            $sql = "SELECT * FROM appointments WHERE appointments_id = ?";
            $run_select = $conn->prepare($sql);
            $run_select->bind_param("i", $update_id);
            $run_select->execute();
            $result_select = $run_select->get_result();

            if ($result_select->num_rows > 0) {
                $row = $result_select->fetch_assoc();
        ?>
        <!-- forma za vnes na novite podatoci koj so ke se updejtirat -->
        <form action="" method="post">

        <?php require "employee_header.php"; ?><!--Vcituvanje na header delot  -->

            <input type="hidden" name="appointments_id" value="<?php echo $update_id; ?>">
            <h2 style="color: #007bff;">Ажурирај термин</h2>
            
            <label for="appointment_date">Датум</label>
            <input type="text" name="appointment_date" id="appointment_date" class="form-control" value="<?php echo $row['appointment_date']; ?>"><br>
           
            <label for="status">Статус</label><br>
            <select name="status" id="status">
    <?php
    $sql = "SHOW COLUMNS FROM appointments LIKE 'status'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $enum_values = explode("','", substr($row['Type'], 6, -2));

        foreach ($enum_values as $value) {
            echo "<option value=\"$value\">$value</option>";
        }
    }
    ?>
</select><br><br>

            <!-- dugmeto za procesiranje na podatocite -->
            <input type="submit" class="btn btn-success" value="Ажурирај">
        </form>
        <?php
            if (isset($success_message)) {
                echo "<div class='alert alert-success'>$success_message</div>";
            } elseif (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
        } else {
            echo "Teminot не е пронајдена.";
        }
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
