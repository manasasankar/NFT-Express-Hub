<?php


$host = 'localhost';
$database = 'nft';
$username = 'root';
$password = '';

$connection = mysqli_connect($host, $username, $password, $database);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

if (isset($_GET['name'])) {
    $name = $_GET['name'];

    // Fetch current click count from the database
    $query = "SELECT clicks FROM images_clicks WHERE name = '$name'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $clicks = $row['clicks'] + 1;

        // Update click count in the database
        $update_query = "UPDATE images_clicks SET clicks = $clicks WHERE name = '$name'";
        $update_result = mysqli_query($connection, $update_query);

        if (!$update_result) {
            echo "Failed to update click count: " . mysqli_error($connection);
        }
    } else {
        echo "Failed to fetch click count: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
