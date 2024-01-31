<?php

require_once "../app/config/config.php";
    require_once "../app/classes/User.php";
    $user = new User();





if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $user = new User();//kreirame objekt od taa klasa no bidejki go kreiravme vo header od tuka ke go izbriseme , ne ni treba dva pati
   $hashed_password = password_hash($password, PASSWORD_DEFAULT);
   $sql = "INSERT INTO users  (username , email , password) VALUES (?,?,?)";
   $stmt =$conn->prepare($sql);

   $stmt->bind_param("sss", $username, $email, $hashed_password);
   
   $result = $stmt->execute();

   


    if($created){
        $_SESSION['message']['type'] = "success";
        $_SESSION['message']['text'] = "Успешно креиравте акаунт";
        header("Location: ../admin/index.php");
        exit();
    }else {
        $_SESSION['message']['type'] = "danger";
        $_SESSION['message']['text'] = "Настана грешка при креирање на акаунт , обидете се повторно!";
        header("Location: ../admin/index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/css/css_admin/registracija_korisnik_style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">

    <title>Регистрација</title>
</head>
<body>
    <div class="registration-container">
        <h1>Регистрација</h1>
        <div class="container">
            <form method="post" action="">
                <div class="form-group mb-3">
                    <label for="name">Име</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group mb-3">
                    <label for="username">Корисничко име</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Емаил адреса</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Лозинка</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Регистрирај нов корисник</button>
               
            </form>
            <br>
            <a href="index.php" class="btn btn-success">Врати се назад</a>
        </div>
    </div>
</body>
</html>

   