<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFT Collections</title>
    <style>
        .popup {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.4); 
}

.popup-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    text-align: center;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

    </style>
</head>
<body align="center" style="background:LightYellow">
    <h1>DISCOVER OUR NFT COLLECTIONS </h1>
    <h3><a href="userpurchases.php">My Purchases</a></h3>
    <h2><a href="upload.html">Upload your artwork here</a></h2>

    <?php
    include 'login.php';
    
    $host = 'localhost';
    $database = 'nft';
    $username = 'root';
    $password = '';

    $connection = mysqli_connect($host, $username, $password, $database);

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    if (isset($_POST['buy_button'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $username = $_SESSION['username'];

        $insert_query = "INSERT INTO purchase (username, name, price) VALUES ('$username', '$name', '$price')";
        $insert_result = mysqli_query($connection, $insert_query);

        if ($insert_result) {
            header("Location: purchase.html");
            exit;
        } else {
            echo "Failed to purchase item: " . mysqli_error($connection);
        }
    }

    $query = "SELECT name, data, price, description FROM images";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $imageCount = 0;

        echo "<table cellspacing='20px' cellpadding='20px' align='center'>";
        
        echo "<tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            if ($imageCount % 4 == 0 && $imageCount != 0) {
                echo "</tr><tr>";
            }
            echo "<td>";
            echo "<a href='#' onclick='showDescription(\"" . $row['description'] . "\")'>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['data']) . "' alt='" . $row['name'] . "' class='nft-image' data-description='" . $row['name'] . "'><br>";
            echo "</a>";
            echo $row['name']."<br>";
            echo $row['price']." ETH";

            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='name' value='" . $row['name'] . "'>";
            echo "<input type='hidden' name='price' value='" . $row['price'] . "'>";
            echo "<input type='submit' name='buy_button' value='Buy'><br>";
            echo "</form>";

            echo "</td>";
            $imageCount++;
        }
        echo "</tr>";
        echo "</table>";
        mysqli_free_result($result);
    } else {
        echo "Failed to retrieve images from the database: " . mysqli_error($connection);
    }

    mysqli_close($connection);
    ?>

    <script>
        function showDescription(description) {
    document.getElementById("description").innerHTML = description;
    document.getElementById("popup").style.display = "block";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}

    </script>
    <div id="popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <p id="description"></p>
    </div>
</div>

</body>
</html>
