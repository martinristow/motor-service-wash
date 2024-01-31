<?php
require_once 'inc/header.php';

$user = new User();

//proveruvame dali sme najaveni
if (!$user->is_logged()) {
    header("Location: login.php");
    exit();
}

//zimame go momentalniot najaven korisnik
$current_user_id = $_SESSION['user_id'];

//zimame gi site podatoci na korisnikot
$sql_select = "SELECT username, email FROM users WHERE user_id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $current_user_id);
$stmt_select->execute();
$result = $stmt_select->get_result();
$user_data = $result->fetch_assoc();

// ako sme kliknale na dugmeto da se isprocesirat podatocite
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        // Ажурирање на податоците
        $new_username = $_POST['username'];
        $new_password = $_POST['password'];
        $new_hashed_password = password_hash($new_password, PASSWORD_ARGON2ID);
        $new_email = $_POST['email'];

        $sql_update = "UPDATE users SET username = ?, password = ?, email = ? WHERE user_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssi", $new_username, $new_hashed_password, $new_email, $current_user_id);
        $update_result = $stmt_update->execute();

        if ($update_result) {
            // Успешно ажурирање на податоците
            $success_message = "Податоците беа успешно ажурирани.";
        } else {
            // Грешка при ажурирање
            $error_message = "Настана грешка при ажурирање на податоците.";
        }
    } elseif (isset($_POST['delete'])) {
        // Избриши го акаунтот
        $sql_delete = "DELETE FROM users WHERE user_id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $current_user_id);
        $delete_result = $stmt_delete->execute();

        if ($delete_result) {
            // Успешно бришење на акаунтот
            session_destroy();
            header("Location: login.php");
            exit();
        } else {
            // Грешка при бришење
            $error_message = "Настана грешка при бришење на акаунтот.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 20px;
        }

        textarea {
            resize: vertical;
        }
    </style>
    <title>Корисници</title>
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
            <h2 style="color: #007bff;">Ажурирај податоци</h2>
            
            <label for="username">Внеси ново корисничко име</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Внеси корисничко име" value="<?php echo $user_data['username']; ?>"><br>
           
            <label for="password">Внеси нова лозинка</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Внеси лозинка"></input><br>
            
            <label for="email">Внеси емаил адреса</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Внеси валидна емаил адреса" value="<?php echo $user_data['email']; ?>"><br>

            <input type="submit" name="update" class="btn btn-success" style="font-weight:bold" value="Ажурирај">
        </form>
        <br>
        <p>Доколку сакате да го избришете вашиот акаунт претиснете на копчето "Избриши акаунт" .</p>
        <form action="" method="post" onsubmit="return confirm('Дали сте сигурни дека сакате да го избришете вашиот акаунт?');">
            <input type="hidden" name="user_id" value="<?php echo $current_user_id; ?>">
            <input type="submit" name="delete" class="btn btn-danger" value="Избриши акаунт" style="font-weight:bold">
        </form>
        
        <?php
            if (isset($success_message)) {
                echo "<div class='alert alert-success'>$success_message</div>";
            } elseif (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

