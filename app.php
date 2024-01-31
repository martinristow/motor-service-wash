<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Calendar</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .appointment {
            background-color: #a3c1ad;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
    // Assuming you have a database connection established
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test2";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get appointments from the database
    $sql = "SELECT * FROM appointments";
    $result = $conn->query($sql);

    // Create an array to store appointment dates
    $appointments = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row['appointment_date'];
        }
    }

    // Close the database connection
    $conn->close();
?>

<h2>Appointments Calendar</h2>

<table>
    <tr>
        <th>Sun</th>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
    </tr>
    <tr>
        <?php
            // Get the current month and year
            $currentMonth = date('n');
            $currentYear = date('Y');

            // Get the first day of the month and the total number of days in the month
            $firstDayOfMonth = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
            $totalDaysInMonth = date('t', $firstDayOfMonth);

            // Get the day of the week for the first day of the month
            $firstDayOfWeek = date('w', $firstDayOfMonth);

            // Display empty cells for the days before the first day of the month
            for ($i = 0; $i < $firstDayOfWeek; $i++) {
                echo '<td></td>';
            }

            // Display the days of the month
            for ($day = 1; $day <= $totalDaysInMonth; $day++) {
                $currentDate = date('Y-m-d', mktime(0, 0, 0, $currentMonth, $day, $currentYear));

                // Start a new row when it's Sunday (day 0)
                if ($firstDayOfWeek == 0) {
                    echo '</tr><tr>';
                }

                // Check if the current date has an appointment
                $isAppointment = in_array($currentDate, $appointments);

                // Highlight appointment dates
                $class = $isAppointment ? 'class="appointment"' : '';

                echo "<td $class>$day</td>";

                // Move to the next day of the week
                $firstDayOfWeek = ($firstDayOfWeek + 1) % 7;
            }

            // Fill in empty cells at the end of the month
            while ($firstDayOfWeek > 0 && $firstDayOfWeek < 7) {
                echo '<td></td>';
                $firstDayOfWeek = ($firstDayOfWeek + 1) % 7;
            }
        ?>
    </tr>
</table>

</body>
</html>
