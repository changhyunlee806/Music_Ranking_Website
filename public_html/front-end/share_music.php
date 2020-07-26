
<?php
    require "connect.php";
    $sql = "USE dzhang29_1;";
    if ($conn->query($sql) === TRUE) {
        // echo "using Database dzhang29_1";
    } else {
        // echo "Error using  database: " . $conn->error;
    }

    session_start();

    $date = date("Ymd");
    $music_title = $_POST['music_title'];
    $artist = $_POST['artist'];
    $points = $_POST['points'];
    $comments = $_POST['comments'];

    //insert to MUSIC if music doesn't already exists &need to check artist
    $new_MusicID = 1;

    $check_music_exist = $conn->query("SELECT * FROM MUSIC WHERE MusicTitle = '$music_title' AND Artist = '$artist';");
    if ($check_music_exist->num_rows == 0){
        $get_last_MusicID = "SELECT * FROM MUSIC ORDER BY MusicID DESC LIMIT 1";

        $last_MusicID = $conn->query($get_last_MusicID);
        if ($last_MusicID->num_rows > 0){
            $row = $last_MusicID->fetch_assoc();
            $new_MusicID = $row["MusicID"] + 1;
        }
        $insert_music = "INSERT INTO MUSIC VALUES ($new_MusicID,'$music_title','$artist');";
        $result = $conn->query($insert_music);

        // if ($result === TRUE) {
        //     echo "New record created successfully";
        // } else {
        //     echo "Error: " . $insert_music . "<br>" . $conn->error;
        // }
    }else{
        $row = mysqli_fetch_assoc($check_music_exist);
        $new_MusicID = $row["MusicID"];
    }
    

    //insert to REVIEW
    $get_last_ReviewID = "SELECT * FROM REVIEW ORDER BY ReviewID DESC LIMIT 1";
    $new_ReviewID = 1;

    $last_ReviewID = $conn->query($get_last_ReviewID);
    if ($last_ReviewID->num_rows > 0){
        $row = $last_ReviewID->fetch_assoc();
        $new_ReviewID = $row["ReviewID"] + 1;
    }
    $UserID = $_SESSION["UserID"];
    $insert_review= "INSERT INTO REVIEW VALUES ($new_ReviewID, $new_MusicID, '$comments','$points', '$date', $UserID );";
    $result = $conn->query($insert_review);

    // if ($result === TRUE) {
    //     echo "New record created successfully";
    // } else {
    //     echo "Error: " . $insert_review . "<br>" . $conn->error;
    // }
    

    //insert to Ranking

    $new_RankingID = 1;
    ////calculate avg points for added music
    $get_Ranking = "SELECT * FROM RANKING JOIN MUSIC ON RANKING.MusicID = MUSIC.MusicID WHERE MusicTitle = '$music_title'";
    
    //// if ranking doesn't exist for the music
    if( mysqli_num_rows($conn->query($get_Ranking)) == 0 ){
    
        $get_last_RankingID = $conn->query("SELECT * FROM RANKING ORDER BY RankingID DESC LIMIT 1");
        if (mysqli_num_rows($get_last_RankingID) > 0){
            $row = mysqli_fetch_assoc($get_last_RankingID);
            $new_RankingID = $row["RankingID"] + 1;
        }

        $avg_points = $points;

        $insert_ranking = "INSERT INTO RANKING VALUES ($new_RankingID,$avg_points,$new_MusicID, 1);";
        $result = $conn->query($insert_ranking);
        // if ($result === TRUE) {
        //     echo "New record created successfully";
        // } else {
        //     echo "Error: " . $sql . "<br>" . $conn->error;
        // }
    }else if( mysqli_num_rows($conn->query($get_Ranking)) == 1 ){
        // retrieve ranking row of the music
        $row = mysqli_fetch_assoc($conn->query($get_Ranking));
        // add up all the points from ranking table and the new review
        $total_pts = $row["Points"] * $row["NumReviews"] + $points;
        $avg_points = $total_pts/($row["NumReviews"] + 1);

        $new_RankingID = $row["RankingID"];
        $new_NumReviews = $row["NumReviews"] + 1;
        //update Ranking table
        $update_ranking = "UPDATE RANKING SET Points = $avg_points, NumReviews = $new_NumReviews WHERE RankingID = $new_RankingID;";
        $result = $conn->query($update_ranking);
        // if ($result === TRUE) {
        //     echo "New record created successfully";
        // } else {
        //     echo "Error: " . $sql . "<br>" . $conn->error;
        // }
    }
    
    //insert to Updates
    $insert_updates = "INSERT INTO UPDATES VALUES ($new_ReviewID,$new_RankingID,$date);";
    $result = $conn->query($insert_updates);
    //insert to shares
    $insert_shares = "INSERT INTO SHARES VALUES ($UserID,$new_ReviewID,$date);";
    $result = $conn->query($insert_shares);

    $conn->close();
    echo '<script>alert("Shared successfully! Thank you for sharing the music!")</script>';
    header("Refresh:0; url=../front-end/post.php");    
    
?>
