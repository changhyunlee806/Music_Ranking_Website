<?php

    require "connect.php";
    $sql = "USE dzhang29_1;";
    if ($conn->query($sql) === TRUE) {
       //echo "using Database dzhang29_1";
    } else {
       echo "Error using  database: " . $conn->error;
    }

    session_start();


    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $subscriber = $_POST['subscriber'];
    $password = $_POST['password'];

    $subscriber_value = 0;
    if($subscriber == 'on'){
        $subscriber_value = 1;
    }else{
        $subscriber_value = 0;
    }

    $select_email = "SELECT * FROM USER WHERE Email = '$email';";
    $result_select_email = $conn->query($select_email);
    $email_count = mysqli_num_rows($result_select_email);

    if($email_count > 0 ) {
        echo '<script>alert("Email submitted already exists")</script>';
        header("Refresh:0; url=../front-end/signup.html");
    }else if(strlen($name) > 30){
        echo '<script>alert("Username is too long, must be less than 30 characters")</script>';
        header("Refresh:0; url=../front-end/signup.html");
    }else if(strlen($password) > 30){
        echo '<script>alert("Password is too long; must be less than 30 characters")</script>';
        header("Refresh:0; url=../front-end/signup.html");
    }else{
        //find out how many users in the USER database
        $sql = "SELECT * FROM USER ORDER BY UserID DESC LIMIT 1";

        $new_UserID = 1;

        $user_num = $conn->query($sql);
        if ($user_num->num_rows > 0){
            $row = $user_num->fetch_assoc();
            $new_UserID = $row["UserID"] + 1;
        }

        //add new user
        $insert_user = "INSERT INTO USER VALUES($new_UserID, '$name', '$phone', '$email', $subscriber_value, '$password','User');";
        $result_insert_user = $conn->query($insert_user);
        if ($result_insert_user == TRUE) {
            echo "works";
        } else {
            echo "Error using  database: " . $conn->error;
        }

        //session_register("myusername");
        $_SESSION['UserID'] = $new_UserID;

        header('Location: ../front-end/main.php');
    }
?>
