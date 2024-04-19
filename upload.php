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

if (isset($_POST['submit'])) {
    $imageName = $_POST['filename'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageData = file_get_contents($imageTmpName);
    $imageName = mysqli_real_escape_string($connection, $imageName);
    $imagePrice = $_POST['price'];
    $description = $_POST['ta']; 

    $checkNameQuery = "SELECT name FROM images WHERE name = ?";
    $checkNameStmt = mysqli_prepare($connection, $checkNameQuery);
    mysqli_stmt_bind_param($checkNameStmt, "s", $imageName);
    mysqli_stmt_execute($checkNameStmt);
    mysqli_stmt_store_result($checkNameStmt);

    if (mysqli_stmt_num_rows($checkNameStmt) > 0) {
        echo "Image with the same name already exists. Please choose a different name.";
        exit();
    }

    mysqli_stmt_close($checkNameStmt);

    $checkDataQuery = "SELECT data FROM images WHERE data = ?";
    $checkDataStmt = mysqli_prepare($connection, $checkDataQuery);
    mysqli_stmt_bind_param($checkDataStmt, "s", $imageData);
    mysqli_stmt_execute($checkDataStmt);
    mysqli_stmt_store_result($checkDataStmt);

    if (mysqli_stmt_num_rows($checkDataStmt) > 0) {
        echo "Image with the same data already exists.";
        exit();
    }

    mysqli_stmt_close($checkDataStmt);

    $query = "INSERT INTO images (name, data, price, description) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssds", $imageName, $imageData, $imagePrice, $description);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: explore.php");
        exit();
    } else {
        echo "Failed to upload image: " . mysqli_error($connection);
    }
}

mysqli_close($connection);

?>
