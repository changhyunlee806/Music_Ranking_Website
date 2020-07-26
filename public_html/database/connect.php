<?php
    $servername = "localhost";
    $username = "dzhang29";
    $password = "B4DHrirh";

    $conn = mysqli_connect($servername, $username, $password);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        echo "Connect Error.\n";
    }
    //echo "Connected successfully\n";
?>
