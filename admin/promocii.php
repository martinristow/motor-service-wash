<?php

require '../app/config/config.php';
require '../app/classes/User.php';


?>
<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $special_offer=$_POST['special_offer_izberi'];
    $promotion_name=$_POST['promotion_name'];
    $description=$_POST['description'];
    $discount_percentage=$_POST['discount_percentage'];
    $contact_message=$_POST['contact_message'];
    
   
    $sql = "INSERT INTO promotions (promotion_name,description,discount_percentage,special_offer,contact_message) VALUES (?,?,?,?,?)";
    $run = $conn->prepare($sql);
    $run->bind_param("ssiss", $promotion_name, $description,$discount_percentage,$special_offer,$contact_message);
    $run->execute();
}

if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM promotions WHERE promotion_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    if ($stmt_delete->execute()) {
        echo "Промоцијата е успешно избришана.";
    } else {
        echo "Грешка при бришење на промоцијата: " . $stmt_delete->error;
    }
}





$sql = "SELECT * FROM promotions";
$run = $conn->query($sql);
$resultat = $run->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_admin/promocii_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Промоции</title>
</head>
<body>
    <div class="container">
    <?php require "admin_header.php"; ?><!--Vcituvanje na header delot  -->

        <form action="" method="post">
            <h2 style="color: #007bff;">Креирај промоција</h2><br>
            
            <label for="special_offer">Избери тип на промоција</label>
<select name="special_offer_izberi" id="special_offer_izberi">
    <?php
    $sql = "SHOW COLUMNS FROM promotions LIKE 'special_offer'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    
        $enum_values = explode("','", substr($row['Type'], 6, -2));

        foreach ($enum_values as $value) {
            echo "<option value=\"$value\">$value</option>";
        }
    }
    ?>
</select>


<br><br>

            <label for="promotion_name">Внеси име на промоцијата</label>
            <input type="text" name="promotion_name" id="promotion_name" class="form-control"><br>
           
            <label for="description">Внеси опис на промоцијата</label>
            <textarea name="description" id="description" class="form-control" cols="60" rows="5"></textarea><br>
            
            <label for="discount_percentage">Внеси цена на промоцијата</label>
            <input type="number" name="discount_percentage" id="discount_percentage" class="form-control"><br>
            

            <label for="contact_message">Внеси контакт информации</label>
            <input type="text" name="contact_message" id="contact_message" class="form-control">
      
            <br>
            <button type="submit" class="btn btn-success">Додај</button>
        </form>

     
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ИД</th>
                    <th>Специјална понуда</th>
                    <th>Име на промоцијата</th>
                    <th>Опис</th>
                    <th>Процент на попуст</th>
                    <th>Контакт порака</th>  
                    <th>Акција</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultat as $promotion) : ?>
                    <tr>
                        <td><?php echo $promotion['promotion_id']; ?></td>
                        <td><?php echo $promotion['special_offer']; ?></td>
                        <td><?php echo $promotion['promotion_name']; ?></td>
                        <td><?php echo $promotion['description']; ?></td>
                        <td><?php echo $promotion['discount_percentage'] ."$"; ?></td>
                        <td><?php echo $promotion['contact_message']; ?></td>
                        <td>

                            <a href="?delete_id=<?php echo $promotion['promotion_id']; ?>" class="btn btn-danger" onclick="return confirm('Дали сте сигурни?')">Избриши</a><br>
                            <a href="update_promocii.php?update_id=<?php echo $promotion['promotion_id']; ?>" class="btn btn-primary" onclick="return confirm('Дали сте сигурни?') ">Ажурирај</a>
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
