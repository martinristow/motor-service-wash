<?php
require '../app/config/config.php';
require '../app/classes/User.php';

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
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];
    $new_hashed_password = password_hash($new_password, PASSWORD_ARGON2ID);
    $new_email = $_POST['email'];

    //pravime update na podatocite
    $sql_update = "UPDATE users SET username = ?, password = ?, email = ? WHERE user_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $new_username, $new_hashed_password, $new_email, $current_user_id);
    $update_result = $stmt_update->execute();

    if ($update_result) {
        //ako sme uspesno napravile update na podatocite
        $success_message = "Податоците беа успешно ажурирани.";
    } else {
        //greska pri update
        $error_message = "Настана грешка при ажурирање на податоците.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_employee/update_akaunt_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Корисници</title>
</head>
<body>
    <div class="container">
       
       
        <form action="" method="post">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">ВРАБОТЕН ПАНЕЛ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="../index.php">Почетна</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="notifikacii.php">Пораки</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="test.php">Услуги</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="termini.php">Термини</a>
    </li>
</ul>

<ul class="navbar-nav ml-auto">
<li class="nav-item">
        <a class="nav-link" href="../update_akaunt.php">Акаунт</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../logout.php">Одјави се</a>
    </li>
</ul>

        </div>
    </div>
</nav><br>
            <input type="hidden" name="user_id" value="<?php echo $update_id; ?>">
            <h2 style="color: #007bff;">Ажурирај податоци</h2>
            
            <label for="username">Внеси ново корисничко име</label>
            <input type="text" name="username" id="username" class="form-control"placeholder="Внеси корисничко име" ><br>
           
            <label for="password">Внеси нова лозинка</label>
            <input type="password" name="password" id="password" cols="60" rows="5" class="form-control" placeholder="Внеси лозинка"></input><br>
            
            <label for="email">Внеси емаил адреса</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Внеси валидна емаил адреса"><br>

           
    


            <input type="submit" class="btn btn-success" value="Ажурирај">
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
