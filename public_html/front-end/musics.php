<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Music Ranking</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/musics.css">
    <link rel="stylesheet" href="css/main.css">
    <!--  Font -->
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include "inc/nav.php"; ?>

    <div class="container" style="width:70%; margin:3% auto;">
        <div class="list-group">

            <?php require "connect.php";
            $sql = "USE dzhang29_1;";
            if ($conn->query($sql) === TRUE) {
               //echo "using Database dzhang29_1";
            } else {
               echo "Error using  database: " . $conn->error;
            }
            $sql = "SELECT MusicTitle,Artist FROM MUSIC;";
           $result = $conn->query($sql);



            while($row = mysqli_fetch_assoc($result)){
                $title = $row['MusicTitle'];
                $select_reviews = "SELECT MUSIC.MusicTitle,MUSIC.Artist,REVIEW.Points,REVIEW.Comments FROM MUSIC LEFT JOIN REVIEW ON MUSIC.MusicID = REVIEW.MusicID WHERE MusicTitle = '$title'";
                $review_result = $conn->query($select_reviews);
                $review_count = mysqli_num_rows($review_result);

                echo "<li class='list-group-item d-flex justify-content-between align-items-center'><strong>{$row['MusicTitle']}</strong> BY {$row['Artist']}<span class='badge badge-primary badge-pill'>$review_count</span></li>";
        }


         ?>
        </div>

        <form class="search" action="musics.php" method="post" style="margin:3% 0; float:right;">
            <label for="name">More About the Music</label>
            <input type="text" name="musicName" placeholder="Music Name" required>
            <!-- <label for="name">Artist Name </label>
            <input type="text" name="artistName"> -->

            <button class="btn btn-warning"type="submit" name="button">Search</button>
        </form>

        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "<div class = 'result'>";
                require "connect.php";
                $sql = "USE dzhang29_1;";
                if ($conn->query($sql) === TRUE) {
                   //echo "using Database dzhang29_1";
                } else {
                   echo "Error using  database: " . $conn->error;
                }

                $musicName = trim($_POST['musicName']);
                //$artistName = trim($_POST['artistName']);


                   $sql = "SELECT MUSIC.MusicTitle,MUSIC.Artist,REVIEW.Points,REVIEW.Comments,USER.Name FROM (MUSIC LEFT JOIN REVIEW ON MUSIC.MusicID = REVIEW.MusicID) JOIN USER ON REVIEW.UserID = USER.UserID WHERE MusicTitle = '$musicName'";
                   $result = $conn->query($sql);

               echo"<table class='table'>";
                   echo"<thead class='thead-light'><tr><th>Title</th><th>Artist</th><th>Points</th><th style='width:50%;'>Comments</th><th>User Name</th></tr></thead>\n";
                   echo"<tbody>";
                   while($row = mysqli_fetch_assoc($result)){
                       echo"<tr><th scope='row'>{$row['MusicTitle']}</th><td>{$row['Artist']}</td><td>{$row['Points']}</td><td>{$row['Comments']}</td><td>{$row['Name']}</td></tr>\n";
                   }
                   echo"</tbody>";
                   echo"</table>";
            echo "</div>";
            }
        ?>
    </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
