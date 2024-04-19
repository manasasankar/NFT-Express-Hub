<?php
include 'login.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nft";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['username'])) {
    echo "User not logged in";
    exit();
}

$logged_in_username = $_SESSION['username'];

$sql = "SELECT username, name, price FROM purchase WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    
    echo "<table border='2' align='center'>";
    echo "<tr><th>Name</th><th>Price</th>";
    while ($row = $result->fetch_assoc()) {
        
        echo "<tr><td>". $row["name"] ."</td><td>" . $row["price"] ."</td></tr>";
    }
    echo"</table>";
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>
