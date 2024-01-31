<?php require_once "app/config/config.php";
    require_once "app/classes/User.php";
    $user = new User();
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/style3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .btn-primary {
            background-color: #000;
            color: #007bff;
            font-weight:bold;
            border: 2px solid #007bff;
            padding: 10px 20px;
            font-size: 1.2em;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
            
        }

        .btn-primary:hover {
            background-color: #007bff;
            color: #fff;
        }
        
    </style>

    <title>Автоперална и Сервис</title>
</head>
<body>
<div class="container">
    
    <?php //OD TUKA POCNUVA MENITO ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
    
    <a class="navbar-brand" href="index.php">Автоперална и Сервис</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-targer="" id="dropdown_menu">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse justify-content-between" id="navbarNav">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="index.php">Дома</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <?php if(!$user->is_logged()) : ?>
            <li class="nav-item">
            <a class="nav-link" href="register.php">Регистрирај се</a>
        </li>
    
        <li class="nav-item">
            <a class="nav-link" href="login.php">Најави се</a>
        </li>


        <?php  elseif($user->is_logged() && $user->is_admin()) : //NAJAVEN I KORISNIKOT E ADMIN?>
            <li class="nav-item">
            <a class="nav-link" href="admin/index.php">Админ Панел</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="kalendar.php">Календар</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="notifikacii.php">Пораки</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="services.php">Услуги</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cart.php">Кошничка</a>
        </li>
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle"  id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Акаунт
    </a>
    <div class="dropdown-menu" aria-labelledby="accountDropdown">
        <a class="dropdown-item" href="update_akaunt.php">Ажурирај</a>
       
        <a class="dropdown-item" href="logout.php">Одјави се</a>
    </div>
</li>


        <?php  elseif($user->is_logged() && $user->is_employee()) ://NAJAVEN I KORISNIKOT E EMPLOYEE ?>
            <li class="nav-item">
            <a class="nav-link" href="employee/index.php">Вработен Панел</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="kalendar.php">Календар</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="notifikacii.php">Пораки</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="services.php">Услуги</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cart.php">Кошничка</a>
        </li>
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Акаунт
    </a>
    <div class="dropdown-menu" aria-labelledby="accountDropdown">
        <a class="dropdown-item" href="update_akaunt.php">Ажурирај</a>
    
        <a class="dropdown-item" href="logout.php">Одјави се</a>
    </div>
</li>


        <?php else : //tuka ako sme najaven ke bide neso drugo , a toa e My Orders i Logout  ?>
        <li class="nav-item">
            <a class="nav-link" href="kalendar.php">Календар</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="notifikacii.php">Пораки</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="services.php">Услуги</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cart.php">Кошничка</a>
        </li>
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Акаунт
    </a>
    <div class="dropdown-menu" aria-labelledby="accountDropdown">
        <a class="dropdown-item" href="update_akaunt.php">Ажурирај</a>
      
        <a class="dropdown-item" href="logout.php">Одјави се</a>
    </div>
</li>
      

        <?php endif;//tuka go zavrsuvame phpto ?>      
        </ul>


        
</div>
</nav>
  <div class="dropBox" id="box">
  <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="index.php">Домa</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <?php if(!$user->is_logged()) : ?>
            <li class="nav-item">
            <a class="nav-link" href="register.php">Регистрирај се</a>
        </li>
    
        <li class="nav-item">
            <a class="nav-link" href="login.php">Најави се</a>
        </li>


        <?php  elseif($user->is_logged() && $user->is_admin()) : //NAJAVEN I KORISNIKOT E ADMIN?>
            <li class="nav-item">
            <a class="nav-link" href="admin/index.php">Админ Панел</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="kalendar.php">Календар</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="notifikacii.php">Пораки</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="services.php">Услуги</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Одјави се</a>
        </li>


        <?php  elseif($user->is_logged() && $user->is_employee()) ://NAJAVEN I KORISNIKOT E EMPLOYEE ?>
            <li class="nav-item">
            <a class="nav-link" href="employee/index.php">Вработен Панел</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="kalendar.php">Календар</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="notifikacii.php">Пораки</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="services.php">Услуги</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Одјави се</a>
        </li>


        <?php else : //tuka ako sme najaven ke bide neso drugo , a toa e My Orders i Logout  ?>
        <li class="nav-item">
            <a class="nav-link" href="kalendar.php">Календар</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="notifikacii.php">Пораки</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="services.php">Услуги</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="logout.php">Одјави се</a>
        </li>

        <?php endif;//tuka go zavrsuvame phpto ?>      
        </ul>

    </div>
<div>
<?php

if ($user->is_logged()) : //proverka dali korisnikot e najaven 
    

    // Azurirame go last_activity_time na momentalnoto vreme
    $current_user_id = $_SESSION['user_id'];
    $sql_update = "UPDATE users SET last_activity_time = CURRENT_TIMESTAMP() WHERE user_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $current_user_id);
    $stmt_update->execute();
endif;
?>


    <?php if(isset($_SESSION['message'])) : 
    //ni se pecati tekstot za dobredojdovte nazad
        ?>
    <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
    <?php 
    echo $_SESSION['message']['text'];
    unset ($_SESSION['message']);
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  
   
    <?php endif; ?>