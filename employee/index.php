<?php
require '../app/config/config.php';
require '../app/classes/User.php';

$user = new User();

if ($user->is_logged() && $user->is_employee()) : // proveruvame dali korisnikot e najaven i dali istiot e employee
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_employee/index_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>ВРАБОТЕН ПАНЕЛ</title>
</head>
<body>
    <div class="container">
    
    <?php require "employee_header.php"; ?><!--Vcituvanje na header delot  -->

        <form action="" method="post" class="update-form">
        </form>
        <?php
        if (isset($success_message)) {//pecatime poraka dali e uspesno ili neuspesno
            echo "<div class='alert alert-success'>$success_message</div>";
        } elseif (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>

        <?php //proveruvame gi poslednite najaveni korisnici vo period od 30 minuti
        $last_five_minutes = date('Y-m-d H:i:s', strtotime('-30 minutes'));
        $sql_select = "SELECT * FROM users WHERE last_activity_time > ?";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bind_param("s", $last_five_minutes);
        $stmt_select->execute();


        $result = $stmt_select->get_result();//gi zimame podatocite
        $active_users = $result->fetch_all(MYSQLI_ASSOC);

        echo "<div class='aktivni-korisnici'>";
        
        echo "<h3>Активни кoрисници во последните 30 минути:</h3>";

        foreach ($active_users as $active_user) {// gi pecatime site aktivni korisnici vo poslednite 30 minuti so foreach ciklus
            echo "<span class='active-indicator'></span>{$active_user['username']}<br>";
        }
        echo "</div>";
        ?>

        <?php
        if (isset($_GET['delete_id'])) {//brisenje na korisnik
            $delete_id = $_GET['delete_id'];
            $sql_delete = "DELETE FROM users WHERE user_id  = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $delete_id);

            if ($stmt_delete->execute()) {
                echo "Корисникот е успешно избришан од базата на податоци.";
            } else {
                echo "Грешка при бришење на корисникот од базата на податоци: " . $stmt_delete->error;
            }
        }
        ?>


        <?php  // DOBIVANJE NA SITE KORISNICI I ISTITE SE PODELENI SPORED USER_TYPE
       
        $query = "SELECT * FROM users";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // gi delime vo grupa i istite gi vmetuvame vo niza
            $admini = [];
            $employees = [];
            $customers = [];

            while ($row = $result->fetch_assoc()) {
                switch ($row['user_type']) {
                    case 'employee':
                        $employees[] = $row;
                        break;
                    case 'customer':
                        $customers[] = $row;
                        break;
                    default:
                        break;
                }
            }

            if (!empty($employees) || !empty($customers)) {//pecatime
                echo "<div class='container custom-style'>";
                if (!empty($employees)) {
                    echo "<div class='employee-group custom-style'>";
                    echo "<h3 class='custom-style'>Листа на вработени:</h3>";
                    echo "<ul class='custom-style'>";
                    foreach ($employees as $employee) {
                        echo "<li class='custom-style'>{$employee['username']} </li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                }

                if (!empty($customers)) {
                    echo "<div class='customer-group custom-style'>";
                    echo "<h3 class='custom-style'>Листа на клиенти:</h3>";
                    echo "<ul class='custom-style'>";
                    foreach ($customers as $customer) {
                        echo "<li class='custom-style'>{$customer['username']} <a href='?delete_id={$customer['user_id']}' class='btn btn-danger' onclick='return confirm(\"Дали сте сигурни?\")'>Избриши корисник</a> <a href='update_korisnik.php?update_id={$customer['user_id']}' class='btn btn-primary' onclick='return confirm(\"Дали сте сигурни?\")'>Ажурирај податоци</a></li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                }

                echo "</div>";
            } else {
                echo "Nema rezultati.";
            }
        }
        ?>

        <?php // DUGME ZA REGISTRIRANJE NA NOV KORISNIK
        echo "<br>";
        echo "Регистрирање на нов корисник! ";
        echo "<a class='btn btn-warning' href='registracija_korisnik.php'>" . " Регистрирај  " . "</a>";
        echo "<br>";
        ?>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

<?php endif; ?>
