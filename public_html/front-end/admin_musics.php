<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Users Info</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/admin_allusers.css">

        <!--  Font -->
        <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">
    </head>
    <body>

        <nav class="navbar navbar-dark" style="background-color: #f0a500;">
    <a class="navbar-brand" href="admin_main.php">
        <img src="../pics/musical-note.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Music Ranking
    </a>
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link active" href="admin_main.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin_musics.php">Comments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin_allusers.php">User Info</a>
        </li>
    </ul>
</nav>

<div class="container" style="margin-top:3%;">
    <?php
        require "connect.php";
        $sql = "USE dzhang29_1;";
        if ($conn->query($sql) === TRUE) {
           //echo "using Database dzhang29_1";
        } else {
           echo "Error using  database: " . $conn->error;
        }

    ?>

    <form class="search" action="admin_musics.php" method="post">
        <label for="musicTitle">Manage Comments</label>
        <input type="text" name="musicTitle" placeholder="Music Title" required>

        <button type="submit" name="button">Search</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<div class = 'result'>";
            // require "connect.php";
            // $sql = "USE dzhang29_1;";
            // if ($conn->query($sql) === TRUE) {
            //    //echo "using Database dzhang29_1";
            // } else {
            //    echo "Error using  database: " . $conn->error;
            // }

            $musicTitle = $_POST['musicTitle'];


                $sql = "SELECT MUSIC.MusicTitle,MUSIC.Artist,REVIEW.Points,REVIEW.Comments,REVIEW.ReviewID,REVIEW.Date FROM MUSIC LEFT JOIN REVIEW ON MUSIC.MusicID = REVIEW.MusicID WHERE MusicTitle = '$musicTitle' ORDER BY REVIEW.Date;";
               $result = $conn->query($sql);

               echo"<table class='table'>";
                   echo"<thead class='thead-light'><tr><th>Date</th><th>Title</th><th>Artist</th><th>Points</th><th style='width:50%;'>Comments</th><th>&ensp; &ensp;</th></tr></thead>\n";
                   echo"<tbody>";
                   while($row = mysqli_fetch_assoc($result)){
                       $reviewID = $row['ReviewID'];
                       echo"<tr><th scope='row'>{$row['Date']}</th><td>{$row['MusicTitle']}</td><td>{$row['Artist']}</td><td>{$row['Points']}</td><td>{$row['Comments']}</td><td><a href='admin_delete_comment.php?reviewID=$reviewID'>Delete</a></td></tr>\n";
                   }
                   echo"</tbody>";
                echo"</table>";


    }else{
        $sql = "SELECT MUSIC.MusicTitle,MUSIC.Artist,REVIEW.Points,REVIEW.Comments,REVIEW.ReviewID,REVIEW.Date FROM MUSIC LEFT JOIN REVIEW ON MUSIC.MusicID = REVIEW.MusicID ORDER BY REVIEW.Date";
        $result = $conn->query($sql);

        echo"<table class='table'>";
            echo"<thead class='thead-light'><tr><th>Date</th><th>Title</th><th>Artist</th><th>Points</th><th style='width:50%;'>Comments</th><th>&ensp; &ensp;</th></tr></thead>\n";
            echo"<tbody>";
            while($row = mysqli_fetch_assoc($result)){
                $reviewID = $row['ReviewID'];
                echo"<tr><th scope='row'>{$row['Date']}</th><td>{$row['MusicTitle']}</td><td>{$row['Artist']}</td><td>{$row['Points']}</td><td>{$row['Comments']}</td><td><a href='admin_delete_comment.php?reviewID=$reviewID'>Delete</a></td></tr>\n";
            }
            echo"</tbody>";
         echo"</table>";
    }
    ?>
</div>
