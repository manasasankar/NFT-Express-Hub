<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['t1'])) {
        $first_name = $_POST['t4'];
        $last_name = $_POST['t5'];
        $username = $_POST['t1'];
        $password = $_POST['t2'];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $conn = new mysqli("localhost", "root", "", "nft");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $checkUsernameQuery = $conn->prepare("SELECT username FROM register WHERE username = ?");
        $checkUsernameQuery->bind_param("s", $username);
        $checkUsernameQuery->execute();
        $checkUsernameResult = $checkUsernameQuery->get_result();

        if ($checkUsernameResult->num_rows > 0) {
           
            echo '<script> alert("Username already exists. Please choose a different username."); window.location.href="register.html"; </script>';
        } else {
        
            $sqlUsers = $conn->prepare("INSERT INTO register (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
            $sqlUsers->bind_param("ssss", $first_name, $last_name, $username, $hashedPassword);

            if ($sqlUsers->execute()) {
                
                echo '<script> alert("Registered successfully. Please login to continue."); window.location.href="home.html"; </script>';
            } else {
              
                echo "Error: " . $sqlUsers->error;
            }

            $sqlUsers->close();
        }

        $checkUsernameQuery->close();
        $conn->close();
    }
}
?>
