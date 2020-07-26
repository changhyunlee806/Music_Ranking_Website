<?php

   require "connect.php";
   $sql = "USE dzhang29_1;";
   if ($conn->query($sql) === TRUE) {
      //echo "using Database dzhang29_1";
   } else {
      echo "Error using  database: " . $conn->error;
   }

   session_start();

   //length of email and password and check exist

   $email = $_POST['email'];
   $password = $_POST['password'];

   //check if email exists
   $select_email = "SELECT * FROM USER WHERE Email = '$email';";
   $select_email_result = $conn->query($select_email);
   $email_count = mysqli_num_rows($select_email_result);

   //check if user exists
   $select_user = "SELECT * FROM USER WHERE Email = '$email' AND Password = $password;";
   $select_user_result = $conn->query($select_user);
   $user_count = mysqli_num_rows($select_user_result);

   if(strlen($email) > 30){
      echo '<script>alert("Email is too long, must be less than 30 characters")</script>';
      header("Refresh:0; url=../front-end/login.html");
   }else if(strlen($password) > 30){
      echo '<script>alert("Password is too long; must be less than 30 characters")</script>';
      header("Refresh:0; url=../front-end/login.html");
   }else if($email_count == 0) {
      echo '<script>alert("Email does not exist")</script>';
      header("Refresh:0; url=../front-end/login.html");
   }else if($user_count != 1){
      echo '<script>alert("Your Login Name or Password is invalid")</script>';
      header("Refresh:0; url=../front-end/login.html");
   }else{
      //find UserID from email
      $get_email_row = "SELECT * FROM USER WHERE Email = '$email';";
      $email_row = $conn->query($get_email_row); 
      $row = $email_row->fetch_assoc();
      $UserID = $row["UserID"];
      
      $_SESSION['UserID'] = $UserID;

      //check if User or Admin
      $row = mysqli_fetch_array($select_user_result,MYSQLI_ASSOC);
      $role = $row['Role'];
      //echo $role;
      //echo (strcmp(trim($role),'User'));
      if(trim($role) == 'User'){
         header('Location: ../front-end/main.php');
      }else if(trim($role) == 'Admin'){
         header('Location: ../front-end/admin_main.php');
      }
   }

   // echo"<table border = '1'>";
   // echo"<tr><td>UserID</td><td>Name</td><td>Phone</td><td>Email</td><td>Subscriber</td><td>Password</td></tr>\n";
   // while($row = mysqli_fetch_assoc($result)){
   //     echo"<tr><td>{$row['UserID']}</td><td>{$row['Name']}</td><td>{$row['Phone']}</td><td>{$row['Email']}</td><td>{$row['Subscriber']}</td><td>{$row['Password']}</td></tr>\n";
   // }
   // echo"</table>";

?>
