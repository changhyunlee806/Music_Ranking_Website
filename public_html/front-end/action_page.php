<?php
    require "connect.php";
    $sql = "USE dzhang29_1;";
    if ($conn->query($sql) === TRUE) {
       //echo "using Database dzhang29_1";
    } else {
       echo "Error using  database: " . $conn->error;
    }
    session_start();

    $userID = $_SESSION['UserID'];
    $update_user_query = "UPDATE USER SET Subscriber = 1 WHERE UserID = $userID";
    $result = $conn->query($update_user_query);

    echo '<script>alert("You have successfully paid!")</script>';
    header("Refresh:0; url=/~dzhang29/front-end/account.php");

?>
