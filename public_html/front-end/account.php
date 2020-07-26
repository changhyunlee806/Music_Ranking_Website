<html>

<head>
    <meta charset="utf-8">
    <title>Music Ranking</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/search.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="css/accounts.css">
    <!--  Font -->
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">

    <style>
  * {
  box-sizing: border-box;
  }
  body {
  font-family: Roboto, Helvetica, sans-serif;
  }
  /* Fix the button on the left side of the page */
  .open-btn {
  display: flex;
  justify-content: left;
  }
  /* Style and fix the button on the page */
  .open-button {
  background-color: green;
  color: white;
  padding: 2% 5%;
  margin-left: 5%;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  opacity: 0.8;
  }
  /* Position the Popup form */
  .payment-popup {
  position: relative;
  text-align: center;
  width: 100%;
  }
  /* Hide the Popup form */
  .form-popup {
  display: none;
  position: fixed;
  left: 45%;
  top:5%;
  transform: translate(-45%,5%);
  /* border: 2px solid #666; */
  z-index: 9;
  }
  /* Styles for the form container */
  .form-container {
  width: 100%;
  padding: 20px;
  background-color: #fff;
  box-shadow: 8px 8px 8px 8px #888888;
  }
  /* Full-width for input fields */
  .form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 10px;
  margin: 5px 0 22px 0;
  border: none;
  background: #eee;
  }
  /* When the inputs get focus, do something */
  .form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
  }
  /* Style submit/login button */
  .form-container .btn {
  background-color: #8ebf42;
  color: #fff;
  padding: 12px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
  }
  /* Style cancel button */
  .form-container .cancel {
  background-color: #cc0000;
  }
  /* Hover effects for buttons */
  .form-container .btn:hover, .open-button:hover {
  opacity: 1;
  }
</style>
</head>

<body>
     <?php include "inc/nav.php"; ?>
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

            $sql = "SELECT * FROM USER WHERE USER.UserID = '$userID';";
            $result = $conn->query($sql);

            while($row = mysqli_fetch_assoc($result)){
                $userID = $row['UserID'];
                $name = $row['Name'];
                $phone = $row['Phone'];
                $email= $row['Email'];
                $subscriber= $row['Subscriber'];
            }

        ?>
    <div class="account-container" style="box-shadow:4px 3px 5px 3px #888888;">
        <div id="chartContainer" style="font-size: 5px;height: 300px; width: 80%;height: 40%;margin:0% 10% 3% auto; "></div>

        <div class="left">
            <div class="image">
                <img style="width:300%;" src="../pics/woman.png" alt="avatar">
            </div>

            <h1> <?php echo $name; ?> </h1>
            <div class="informations">
                <p> <span> UserID: &ensp; &ensp;</span><?php echo $userID; ?> </p>
                <p> <span> Phone Number:  <br>&ensp; &ensp;</span><?php echo $phone; ?> </p>
                <p> <span>Email Address:  <br>&ensp; &ensp;</span><?php echo $email; ?> </p>
                <p> <span>Subscriber: </span><?php
                    if ($subscriber == 1) {
                        echo "<i class='fa fa-check-circle fa-2x' style='color:green;'></i>";
                    }else{
                        echo "<i class='fa fa-times-circle fa-2x' style='color:red;'></i>";
                        echo "<button type='button' name='upgrade' class='open-button' onclick='openForm()'>Subscribe</button>";
                    }
                ?> </p>
                <p>
                    <form name="form" method="post" action="/~dzhang29/database/logout.php">
                        <input class="btn btn-light" type="submit" value="Log Out">
                    </form>
                </p>
            </div>

            <div class="payment-popup">
             <div class="form-popup" id="popupForm">
               <form action="action_page.php" class="form-container">
                 <h2>Please Fill in Card Information</h2>

                 <label for="cardnumber"><strong>Card Number</strong></label>
                 <input type="text" id="cardnumber" placeholder="e.g. 1234-1234-1234-1234" name="cardnumber" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}" required>

                 <label for="name"><strong>Name</strong></label>
                 <input type="text" id="name" placeholder="Name" name="name" required>

                 <label for="sc"><strong>Security Code</strong></label>
                 <input type="text" id="sc" placeholder="e.g. 123" name="sc" pattern="[0-9]{3}" required>

                 <label for="ed"><strong>Expiration Date</strong></label>
                 <input type="text" id="ed" placeholder="e.g. 01/20" name="ed" pattern="[0-9]{2}/[0-9]{2}"required>

                 <button type="submit" class="btn">Submit</button>
                 <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
               </form>
             </div>
           </div>

        </div>

        <div class="right">
            <h2>Actions</h2>
            <div class="actions">
                <?php
                   $sql = "SELECT MUSIC.MusicTitle,MUSIC.Artist,REVIEW.Points,REVIEW.Comments,REVIEW.ReviewID,REVIEW.Date FROM MUSIC LEFT JOIN REVIEW ON MUSIC.MusicID = REVIEW.MusicID WHERE REVIEW.UserID = $userID";
                   $result = $conn->query($sql);

                   echo"<table class='table'>";
                       echo"<thead class='thead-light'><tr><th>Date</th><th>Title</th><th>Artist</th><th>Points</th><th style='width:50%;'>Comments</th><th>&ensp; &ensp;</th></tr></thead>\n";
                       echo"<tbody>";
                       while($row = mysqli_fetch_assoc($result)){
                           $reviewID = $row['ReviewID'];
                           echo"<tr><th scope='row'>{$row['Date']}</th><td>{$row['MusicTitle']}</td><td>{$row['Artist']}</td><td>{$row['Points']}</td><td>{$row['Comments']}</td><td><a href='delete_comment.php?reviewID=$reviewID'>Delete</a></td></tr>\n";
                       }
                       echo"</tbody>";
                    echo"</table>";
                ?>
            </div>


        </div>

    </div>

    <!-- <footer>
        Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a>
    </footer> -->

    <!-- Optional JavaScript -->

    <script>
      function openForm() {
        document.getElementById("popupForm").style.display="block";
      }

      function closeForm() {
        document.getElementById("popupForm").style.display="none";
      }
    </script>

    <script>

    var our_data = [];
    insert_data();

    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title:{
            text: "Action Counts per Day"
        },
        axisY: {
            title: "Comments per Day"
        },
        data: [{
            yValueFormatString: "#,### Comments",
        xValueFormatString: "YYYY MMM DD",
        type: "spline",
        dataPoints: our_data
        }]
    });


    chart.render();

    }

    function insert_data(){
        <?php
                require "connect.php";
                $sql = "USE dzhang29_1;";
                if ($conn->query($sql) === TRUE) {
                   //echo "using Database dzhang29_1";
                } else {
                   echo "Error using  database: " . $conn->error;
                }

                $UserID = $_SESSION['UserID'];
                #all dates in SHARES
                $sql = "SELECT COUNT(ReviewID) AS NumComments, UserID, Date
                        FROM SHARES
                        WHERE UserID = $UserID
                        GROUP BY Date
                        ORDER BY Date";
                $result = $conn->query($sql);

                while($row = mysqli_fetch_assoc($result)){
                    $ymd = explode('-', $row['Date']);
                    $year = $ymd[0];
                    $month = $ymd[1];
                    $date = $ymd[2];
                    $num_comm = $row['NumComments'];

        ?>


             our_data.push({x: new Date(<?php echo $ymd[0] ?>, <?php echo $ymd[1] ?>, <?php echo $ymd[2] ?>), y: <?php echo $num_comm ?>});
             //our_data.push({x: new Date(<?php echo $ymd[1] ?>, <?php echo $ymd[2] ?>), y: <?php echo $num_comm ?>});

        <?php
                }
        ?>

    }
</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>


    <!-- function insert_data(){
        <?php
                require "connect.php";
                $sql = "USE dzhang29_1;";
                if ($conn->query($sql) === TRUE) {
                   //echo "using Database dzhang29_1";
                } else {
                   echo "Error using  database: " . $conn->error;
                }

                $UserID = $_SESSION['UserID'];
                #all dates in SHARES
                $sql = "SELECT COUNT(ReviewID) AS NumComments, UserID, Date
                        FROM SHARES
                        WHERE UserID = $UserID
                        GROUP BY Date
                        ORDER BY Date";
                $result = $conn->query($sql);

                while($row = mysqli_fetch_assoc($result)){
                    $ymd = explode('-', $row['Date']);
                    $year = $ymd[0];
                    $month = $ymd[1];
                    $date = $ymd[2];
                    $num_comm = $row['NumComments'];

        ?>


             our_data.push({x: new Date(<?php echo $ymd[0] ?>, <?php echo $ymd[1] ?>, <?php echo $ymd[2] ?>), y: <?php echo $num_comm ?>});

        <?php
                }
        ?>

    } -->
