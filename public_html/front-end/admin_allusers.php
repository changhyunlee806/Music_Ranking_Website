<html>

<head>
    <meta charset="utf-8">
    <title>Music Ranking</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/accounts.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="screen" />
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
    <div class="account-container">
        <div class="left">
            <div class="image">
                <img style="width:300%;" src="../pics/avatar.png" alt="avatar">
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
                        echo "<button type='button' name='upgrade'>Subscribe</button>";
                    }
                ?> </p>
                <p>
                    <form name="form" method="post" action="/~dzhang29/database/logout.php">
                        <input class="btn btn-light" type="submit" value="Log Out">
                    </form>
                </p>
            </div>

        </div>

        <div class="right">
            <h2>All Users</h2>
            <div class="actions">

                <form class="search" action="admin_allusers.php" method="post" style="float:right;">
                    <label for="name">Manage Users</label>
                    <input type="text" name="name" placeholder="User Name" required>

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

                        $name = $_POST['name'];


                            $sql = "SELECT * FROM USER WHERE Name = '$name';";
                           $result = $conn->query($sql);


                       echo"<table class='table'>";
                           echo"<thead class='thead-light'><tr><th>UserID</th><th>Name</th><th>Phone</th><th>Email</th><th>Subscriber</th><th>&ensp; &ensp;</th></tr></thead>\n";
                           echo"<tbody>";
                           $rank = 0;
                           while($row = mysqli_fetch_assoc($result)){
                               $rank = $rank + 1;
                               echo"<tr><th scope='row'>{$row['UserID']}</th><td>{$row['Name']}</td><td>{$row['Phone']}</td><td>{$row['Email']}</td><td>{$row['Subscriber']}</td><td><a href='admin_delete_comment.php?reviewID=$reviewID'>Delete</a></td></tr>\n";
                           }
                           echo"</tbody>";
                           echo"</table>";
                    echo "</div>";
                }else{
                    $sql = "SELECT * FROM USER;";
                   $result = $conn->query($sql);

                   echo"<table class='table'>";
                   echo"<thead class='thead-light'><tr><th>UserID</th><th>Name</th><th>Phone</th><th>Email</th><th>Subscriber</th><th>&ensp; &ensp;</th></tr></thead>\n";
                   echo"<tbody>";
                   $rank = 0;
                   while($row = mysqli_fetch_assoc($result)){
                       $rank = $rank + 1;
                       echo"<tr><th scope='row'>{$row['UserID']}</th><td>{$row['Name']}</td><td>{$row['Phone']}</td><td>{$row['Email']}</td><td>{$row['Subscriber']}</td><td><a href='delete_user.php?userID=$userID'>Delete</a></td></tr>\n";
                   }
                   echo"</tbody>";
                   echo"</table>";
                }
                ?>
            </div>

        </div>

    </div>

    <footer>
        Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
