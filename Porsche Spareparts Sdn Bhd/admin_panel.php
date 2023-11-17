<?php
session_start();

// Check if the admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$servername = "localhost"; // Change this to your MySQL server name
$username = "root";         // Change this to your MySQL username
$password = "";             // Change this to your MySQL password
$dbname = "appointments";   // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM appointments WHERE 
            name LIKE '%$search%' OR 
            email LIKE '%$search%' OR 
            phone LIKE '%$search%' OR 
            appointment_date LIKE '%$search%' OR 
            car_model LIKE '%$search%' OR 
            message LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM appointments";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .logout-btn {
            display: block;
            padding: 8px 16px;
            margin-top: 20px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h2>Welcome, Admin!</h2>
    
    <h3>All Appointments</h3>
    <form method="post">
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search...">
        <input type="submit" value="Search">
    </form>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Appointment Date</th>
                <th>Car Model</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['appointment_date'] . "</td>";
                    echo "<td>" . $row['car_model'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No appointments found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>
