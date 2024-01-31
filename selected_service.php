<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $service_name = $_POST['service_name'];

    // Save the selected service in the session
    $_SESSION['selected_service'] = $service_name;

    // If you want to save the selected service to the database, you can use your database connection and perform an INSERT query here
    $mysqli = new mysqli("localhost", "root", "", "test2");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Assuming 'services' table structure with service_id as auto-incremented primary key
    $insert_query = "";

    // Specify description and price based on service name
    if ($service_name == "Перење") {
        $description = "Перење на возило";
        $price = "5.00$";
    } elseif ($service_name == "Сервис") {
        $description = "Сервис за возило,цената на лице место";
        // You can set the price based on your specific criteria or leave it blank for further customization
        $price = ""; // You may set an appropriate value or leave it blank
    } else {
        // If there are other services, you can add more conditions here
        $description = "Description not available";
        $price = "Price not available";
    }

    // Insert into the 'services' table
    $insert_query = "INSERT INTO services (service_name, description, price) VALUES ('$service_name', '$description', '$price')";

    if ($mysqli->query($insert_query) === TRUE) {
        echo "Service inserted into the database successfully!";
    } else {
        echo "Error: " . $mysqli->error;
    }

    $mysqli->close();

    // Redirect to another page or perform further actions as needed
    header("Location: kalendar.php");
    exit();
} else {
    // Redirect if the form is not submitted
    header("Location: index.php");
    exit();
}
?>

<?php require_once 'inc/footer.php'; ?>