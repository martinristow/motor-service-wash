<?php
require '../app/config/config.php';
require '../app/classes/User.php';
?>

<?php

if(isset($_GET['delete_id'])) {//brisenje
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM services WHERE service_id  = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    if ($stmt_delete->execute()) {
        echo "Успешно е избришано.";
    } else {
        echo "Грешка при бришење: " . $stmt_delete->error;
    }
}


// zemi gi site podatoci od tabela services
$sql = "SELECT * FROM services";
$run = $conn->query($sql);
$resultat = $run->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/css_employee/test_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Услуги</title>

</head>
<body>
    <div class="container">
    <?php require "employee_header.php"; ?><!--Vcituvanje na header delot  -->

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ИД</th>
                    <th>Име на сервисот</th>
                    <th>Опис</th>
                    <th>Цена</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultat as $services) : ?>
                    <tr>
                        <td><?php echo $services['service_id']; ?></td>
                        <td><?php echo $services['service_name']; ?></td>
                        <td><?php echo $services['description']; ?></td>
                        <td><?php echo $services['price'] . " денари"; ?></td>
                        
                        
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
