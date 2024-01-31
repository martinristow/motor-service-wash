<?php

require '../app/config/config.php';
require '../app/classes/User.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_SESSION['user_id'])) {
        // Dobavi trenutno prijavljenog korisnika
        $user_id = $_SESSION['user_id'];
        
    
    $naslov=$_POST['naslov'];
    $message=$_POST['message'];
   
    $sql = "INSERT INTO posts (user_id,naslov,text) VALUES (?,?,?)";
    $run = $conn->prepare($sql);
    $run->bind_param("iss", $user_id,$naslov, $message);
    $run->execute();
}}

if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM posts WHERE post_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    if ($stmt_delete->execute()) {
        
        
        
            
        echo "Постот е успешно избришан.";
    } else {
        echo "Грешка при бришење на постот: " . $stmt_delete->error;
    }


}



$sql = "SELECT * FROM posts";
$run = $conn->query($sql);
$resultat = $run->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_admin/objavi_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Notifikacii</title>
</head>
<body>
    <div class="container">
    <?php require "admin_header.php"; ?><!--Vcituvanje na header delot  -->
      
        <form action="" method="post">
            <h2 style="color: #007bff;">Креирај објава</h2><br>
        
            <input type="text" name="naslov" id="naslov"cols="80" placeholder="Внеси наслов на објавата"></input><br><br>
            <textarea name="message" id="message" cols="80" rows="10" placeholder="Внеси текст на објавата" maxlenght="2000"></textarea>
            
            <br>
            
     
            <input class="btn btn-success" type="submit" value="Креирај објава">
        </form>

       
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ИД</th>
                    <th>Кориснички ИД</th>
                    <th>Наслов на објавата</th>
                    <th>Текст на објавата</th>
                    <th>Време на објавување</th>
                    <th>Акција</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultat as $post) : ?>
                    <tr>
                        <td><?php echo $post['post_id']; ?></td>
                        <td><?php echo $post['user_id']; ?></td>
                        <td><?php echo $post['naslov']; ?></td>
                        <td><?php echo $post['text']; ?></td>
                        <td><?php echo $post['vreme_na_kreiranje']; ?></td>
                        <td>
                            <a class="btn btn-danger" href="?delete_id=<?php echo $post['post_id']; ?>" onclick="return confirm('Дали сте сигурни?')">Избриши</a>
                        
                        
                            <a class="btn btn-success" href="update_objavi.php?update_id=<?php echo $post['post_id']; ?>" onclick="return confirm('Дали сте сигурни?')">Ажурирај</a>
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
