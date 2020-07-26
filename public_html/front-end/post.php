<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Music Ranking</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/post.css">
    <!--  Font -->
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">
</head>

<body>
<?php include "inc/nav.php"; ?>

    <h1 style="text-align:center; margin-top:3%;">Post a New Review</h1>
    <div class="container" style="width:65%; box-shadow: 5px 5px 8px #888888;">


        <form name="form" method="post" action="share_music.php">
            <small id="help" class="form-text" style="color:red; text-align:right;">Fields with * is requred</small>

            <div class="form-group row">
                <label for="music_title" class="col-sm-2 col-form-label">Music Title<span style="color:red;">*</span></label>
                <div class="col-sm-10">
                    <input type="text" id="title" name="music_title" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="artist" class="col-sm-2 col-form-label">Artist<span style="color:red;">*</span></label>
                <div class="col-sm-10">
                    <input type="text" id="artist" name="artist" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="points" class="col-sm-2 col-form-label">Points<span style="color:red;">*</span></label>
                <div class="col-sm-10">
                    <input type="number" id="points" name="points" step="0.1" min="0" max="10" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="comments" class="col-sm-2 col-form-label">Comments</label>
                <div class="col-sm-10">
                    <textarea name="comments" rows="8" cols="80"></textarea>
                </div>
            </div>

            <input class="btn btn-light" type="submit" value="Submit" style="float:right;">
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
