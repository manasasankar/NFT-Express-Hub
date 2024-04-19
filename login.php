<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['t1'], $_POST['t2'])) {
        
        $username = $_POST['t1'];
        $password = $_POST['t2'];

        $conn = new mysqli("localhost","root","","nft");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql_check = $conn->prepare("SELECT * FROM register WHERE username = ?");
        $sql_check->bind_param("s", $username);
        $sql_check->execute();
        $result = $sql_check->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
            
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['username'] = $username; 
                
                header("Location: explore.php");
                exit();
            } else {
                echo '<script> alert("Incorrect password, Try again"); window.location.href="home.html"; </script>';
            }
        } else {
            echo '<script> alert("User not found, Try again"); window.location.href="home.html"; </script>';
        }

        $sql_check->close();
        $conn->close();
    } 
}
?>
