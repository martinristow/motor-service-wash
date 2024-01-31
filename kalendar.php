<?php
require_once "inc/header.php";
define("ADAY", (60 * 60 * 24));

if (isset($_POST['submit_service'])) {
  
    $selected_service = $_POST['service'];
    
    
    $_SESSION['selected_service'] = $selected_service;
} 


if ((!isset($_POST['month'])) || (!isset($_POST['year']))) {
    $nowArray = getdate();
    $month = $nowArray['mon'];
    $year = $nowArray['year'];
} else {
    $month = $_POST['month'];
    $year = $_POST['year'];
}

$start = mktime(12, 0, 0, $month, 1, $year);
$firstDayArray = getdate($start);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo "Calendar: " . $firstDayArray['month'] . " " . $firstDayArray['year']; ?></title>
  <style>
    body {
    font-family: 'Rubik', Tahoma, Geneva, Verdana, sans-serif;
    margin: 20px;
    background: url('https://bergen.edu/wp-content/uploads/Academic-Calendar-header.jpg') no-repeat center center fixed;
    background-size: cover;
}

h1, h2 {
    text-align: center;
    color: #800000;
    font-weight:bold;
}

form {
    text-align: center;
    margin-bottom: 20px;
}

select, button {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
    font-size: 18px;
    color: #ffffff; 
}

th {
    background-color: #8c2387;
    color: white;
}

td {
    background-color: #d89723;
    height: 100px;
    position: relative;
    transition: background-color 0.3s ease;
}


.event-container {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 5px;
    background-color: #fff;
    opacity: 0.8;
}

form[name="schedule-form"] {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
}

input[type="date"], button[name="schedule_submit"] {
    margin-top: 10px;
}
/* Stilizacija input elementa tipa date */
input[type="date"] {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    border: 1px solid #ced4da;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 14px;
    outline: none;
    box-shadow: none;
}

/* Podešavanje izgleda hover stanja */
input[type="date"]:hover {
    border-color: #6c757d;
}

/* Podešavanje izgleda fokusiranog stanja */
input[type="date"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
.btn{
    font-weight:bold;
    color:darkred;
}
.text{
    color:white;
    font-weight:bold;
}

  </style>  
</head>
<body>
    <h1>Изберете месец/година</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <select name="month">
            <?php
            $months = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            for ($x = 1; $x <= count($months); $x++) {
                echo "<option value=\"$x\"";
                if ($x == $month) {
                    echo " selected";
                }
                echo ">" . $months[$x - 1] . "</option>";
            }
            ?>
        </select>
        <select name="year">
            <?php
            $currentYear = date('Y');
            for ($x = $currentYear; $x <= 2025; $x++) {
                echo "<option";
                if ($x == $year) {
                    echo " selected";
                }
                echo ">$x</option>";
            }
            ?>
        </select>
        <button type="submit" class="btn btn-warning" name="submit" value="submit">Оди!</button>
    </form>
    <br>

    <?php
    $days = Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
    echo "<table><tr>\n";
    foreach ($days as $day) {
        echo "<th>" . $day . "</th>\n";
    }
    for ($count = 0; $count < (6 * 7); $count++) {
        $dayArray = getdate($start);
        if (($count % 7) == 0) {
            if ($dayArray['mon'] != $month) {
                break;
            } else {
                echo "</tr><tr>\n";
            }
        }
        if ($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
            echo "<td>&nbsp;</td>\n";
        } else {
            $event_title = "";

            $mysqli = mysqli_connect("localhost", "root", "", "test2");
            $appointment_date = date("Y-m-d", $start);
            $fetchAppointments_sql = "SELECT * FROM appointments WHERE appointment_date = '$appointment_date'";
            $fetchAppointments_res = mysqli_query($mysqli, $fetchAppointments_sql) or die(mysqli_error($mysqli));

            while ($appointment = mysqli_fetch_assoc($fetchAppointments_res)) {
                $event_title .= $appointment['status'] . "<br>";
            }

            echo "<td>" . $dayArray['mday'] . "<br>" . $event_title . "</td>\n";

            unset($event_title);

            $start += ADAY;
        }
    }
    echo "</tr></table>";

  
    mysqli_close($mysqli);
    ?>

    <h2>Закажете термин</h2>
    <form method="post" action="schedule.php">
        <label for="appointment_date" class="text">Датум:</label>
        <input type="date" name="appointment_date" required>

        <button type="submit" class="btn btn-warning" name="schedule_submit">Закажи термин</button>
    </form>
</body>
</html>
<?php require_once 'inc/footer.php'; ?>