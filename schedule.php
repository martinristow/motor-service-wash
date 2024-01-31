<?php
if (isset($_POST['schedule_submit'])) {
    // Process form data
    $appointment_date = $_POST['appointment_date'];

    // Additional processing and validation

    // Insert the appointment into the database
    $mysqli = mysqli_connect("localhost", "root", "", "test2");

    // Perform the database insertion (adjust this part based on your database schema)
    $insertAppointment_sql = "INSERT INTO appointments (appointment_date) VALUES ('$appointment_date')";
    mysqli_query($mysqli, $insertAppointment_sql) or die(mysqli_error($mysqli));

    // Close the database connection
    mysqli_close($mysqli);

    // Redirect to the calendar page or show a success message
    header("Location: cart.php");
    exit();
}
?>

<?php require_once 'inc/footer.php'; ?>