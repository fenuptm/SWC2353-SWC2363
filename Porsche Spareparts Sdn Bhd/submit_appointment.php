<?php
$servername = "localhost"; // Change this to your MySQL server name
$username = "root";     // Change this to your MySQL username
$password = "";     // Change this to your MySQL password
$dbname = "appointments";         // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $appointment_date = $_POST["appointment_date"];
    $car_model = $_POST["car_model"];
    $message = $_POST["message"];

    $sql = "INSERT INTO appointments (name, email, phone, appointment_date, car_model, message) 
            VALUES ('$name', '$email', '$phone', '$appointment_date', '$car_model', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
