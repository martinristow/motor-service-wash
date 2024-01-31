<?php
require '../app/config/config.php';
require '../app/classes/User.php';

$update_id = isset($_GET['update_id']) ? $_GET['update_id'] : '';

// ako update_id ne e zemen togas vrni go nazad
if ($update_id === '') {
    header("Location: update_korisnik.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash_password = password_hash($password,PASSWORD_ARGON2ID);
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $user_id = $_POST['user_id'];


    $sql_update = "UPDATE users SET username = ?, password = ?, email = ?, user_type = ? WHERE user_id = ?";
    $run = $conn->prepare($sql_update);
    $run->bind_param("ssssi", $username, $hash_password, $email,$user_type, $user_id);

    
    if ($run->execute()) {
        $success_message = "Корисникот е успешно ажуриран.";
    } else {
        $error_message = "Грешка при ажурирање на корисникот: " . $run->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_admin/update_korisnik_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Корисници</title>
</head>
<body>
    <div class="container">
        <?php 
            $sql = "SELECT * FROM users WHERE user_id = ?";
            $run_select = $conn->prepare($sql);
            $run_select->bind_param("i", $update_id);
            $run_select->execute();
            $result_select = $run_select->get_result();

            if ($result_select->num_rows > 0) {
                $row = $result_select->fetch_assoc();
        ?>
       
        <form action="" method="post">
        <?php require "admin_header.php"; ?><!--Vcituvanje na header delot  -->
            <input type="hidden" name="user_id" value="<?php echo $update_id; ?>">
            <h2 style="color: #007bff;">Ажурирај корисник</h2>
            
            <label for="username">Внеси корисничко име</label>
            <input type="text" name="username" id="username" class="form-control"placeholder="Внеси корисничко име" ><br>
           
            <label for="password">Внеси лозинка</label>
            <input type="password" name="password" id="password" cols="60" rows="5" class="form-control" placeholder="Внеси лозинка"></input><br>
            
            <label for="email">Внеси емаил адреса</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Внеси валидна емаил адреса"><br>

            <label for="user_type">Тип на корисник</label><br>
            <select name="user_type" id="user_type">
    <?php
    $sql = "SHOW COLUMNS FROM users LIKE 'user_type'";
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


            <input type="submit" class="btn btn-success" value="Ажурирај">
        </form>
        <?php
            if (isset($success_message)) {
                echo "<div class='alert alert-success'>$success_message</div>";
            } elseif (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
        } else {
            echo "Корисникот не е пронајден.";
        }
        ?>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
