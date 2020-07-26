<?php

   require "connect.php";
   $sql = "USE dzhang29_1;";
   if ($conn->query($sql) === TRUE) {
      //echo "using Database dzhang29_1";
   } else {
      echo "Error using  database: " . $conn->error;
   }

   session_start();
   unset($_SESSION["UserID"]);
   
   $conn->close();
   echo '<script>alert("You have successfully logged out!")</script>';
   header("Refresh:0; url=/~dzhang29/front-end/login.html");

?>
