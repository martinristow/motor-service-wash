<?php
require_once "inc/header.php";
require_once "app/classes/User.php";//ja povikuvame klasata

if($user->is_logged()){//ako sme najaveni nema da mozeme da se registrirame :D
    header('Location: index.php');
    exit();
}


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];


   // $user = new User();//kreirame objekt od taa klasa no bidejki go kreiravme vo header od tuka ke go izbriseme , ne ni treba dva pati
    $created = $user -> create($name , $username , $email, $password);


    if($created){
        $_SESSION['message']['type'] = "success";
        $_SESSION['message']['text'] = "Успешно се регистриравте на нашиот сајт!";
        header("Location: index.php");
        exit();
    }else {
        $_SESSION['message']['type'] = "danger";
        $_SESSION['message']['text'] = "Неуспешен обид за регистрација , обидете се повторно со друг емаил или друго корисничко име!";
        header("Location: register.php");
        exit();
    }
}

?>

<link rel="stylesheet" href="public/css/register_style.css"><!--Vcituvanje na css -->
      <div class="row justify-content-center">
    <div class="col-lg-5">
      <div class="main">
        <form method="post" action="">
          <h1 class="mt-5 mb-3">Регистрација</h1>

          <div class="form-group mb-3">
            <label for="name">Цело име</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="form-group mb-3">
            <label for="username">Корисничко име</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>

          <div class="form-group mb-3">
            <label for="email">Емаил</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="form-group mb-3">
            <label for="password">Лозинка</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <button type="submit" class="btn btn-primary">Регистрирај се</button>
        </form>
        <a href="login.php">Најава</a>
      </div>
    </div>
  </div>

    <?php require_once 'inc/footer.php';