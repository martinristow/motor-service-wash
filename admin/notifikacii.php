<?php

require '../app/config/config.php';
require '../app/classes/User.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $selected_user_id = $_POST['izberi'];
    $message=$_POST['message'];
   
    $sql = "INSERT INTO notifications (user_id,message) VALUES (?,?)";
    $run = $conn->prepare($sql);
    $run->bind_param("is", $selected_user_id, $message);
    $run->execute();
}


if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM notifications WHERE notification_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    if ($stmt_delete->execute()) {
        echo "Нотификацијата е успешно избришана.";
    } else {
        echo "Грешка при бришење на нотификацијата: " . $stmt_delete->error;
    }
}


$sql = "SELECT * FROM notifications";
$run = $conn->query($sql);
$resultat = $run->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_admin/notifikacii_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Notifikacii</title>
</head>
<body>
    <div class="container">
    <?php require "admin_header.php"; ?><!--Vcituvanje na header delot  -->
      
        <form action="" method="post">
            <h2 style="color: #007bff;">Креирај порака</h2><br>
           
            <?php
            $sql_users = "SELECT * FROM users";
            $run_users = $conn->query($sql_users);
            $users = $run_users->fetch_all(MYSQLI_ASSOC);
            ?>
            <p>Избери корисник<select name="izberi" id="izberi">
                <?php foreach ($users as $user) : ?>
                    <option value="<?php echo $user['user_id']; ?>">
                        <?php echo $user['username']; ?>
                    </option>
                <?php endforeach; ?>
            </select></p>
                
            <textarea name="message" id="message" cols="30" rows="10" placeholder="Внеси опис на промоцијата"></textarea>
            
            <br>

            <input class="btn btn-success" type="submit" value="Внеси">
        </form>

       
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ИД</th>
                    <th>Кориснички ИД</th>
                    <th>Порака</th>
                    <th>Акција</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultat as $notification) : ?>
                    <tr>
                        <td><?php echo $notification['notification_id']; ?></td>
                        <td><?php echo $notification['user_id']; ?></td>
                        <td><?php echo $notification['message']; ?></td>
                        <td>
                        
                            <a class="btn btn-danger" href="?delete_id=<?php echo $notification['notification_id']; ?>" onclick="return confirm('Дали сте сигурни?')">Избриши</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
