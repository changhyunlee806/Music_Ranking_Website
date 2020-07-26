<?php
    require "connect.php";
    $sql = "USE dzhang29_1;";
    if ($conn->query($sql) === TRUE) {
       //echo "using Database dzhang29_1";
    } else {
       echo "Error using  database: " . $conn->error;
    }

    $reviewID = $_REQUEST['reviewID'];


    $select_review_num = "SELECT * FROM REVIEW JOIN RANKING ON REVIEW.MusicID = RANKING.MusicID WHERE `ReviewID` = $reviewID";
    $review_num = $conn->query($select_review_num);

        $row = mysqli_fetch_assoc($review_num);
        $review_number = $row['NumReviews'];
        $musicID = $row['MusicID'];

    $select_points = "SELECT * FROM REVIEW WHERE ReviewID= $reviewID";
    $get_points = $conn->query($select_points);
    $row = mysqli_fetch_assoc($get_points);
    $points = $row['Points'];

    $delete_review_query="DELETE FROM REVIEW WHERE ReviewID= $reviewID";
    $review_deleted=$conn->query($delete_review_query);


     if($review_number == 1){
         $delete_ranking_query="DELETE FROM RANKING WHERE MusicID = $musicID";
         $ranking_deleted=$conn->query($delete_ranking_query);


         $delete_music_query="DELETE FROM MUSIC WHERE MusicID = $musicID";
         $music_deleted=$conn->query($delete_music_query);

         if ($music_deleted == TRUE) {
            //echo "using Database dzhang29_1";
         } else {
            echo "Error using  database: " . $conn->error;
         }

     }else{
         $select_ranking = "SELECT * FROM RANKING WHERE MusicID = $musicID";
         $row = mysqli_fetch_assoc($conn->query($select_ranking));

         $total_pts = $row["Points"] * $review_number - $points;

         $avg_points = $total_pts/($review_number - 1);

         //echo $avg_points;


        $new_RankingID = $row["RankingID"];
        $new_NumReviews = $row["NumReviews"] - 1;
        //update Ranking table
        $update_ranking = "UPDATE RANKING SET Points = $avg_points, NumReviews = $new_NumReviews WHERE RankingID = $new_RankingID;";
        $result = $conn->query($update_ranking);
     }


         $delete_review_query="DELETE FROM REVIEW WHERE ReviewID= $reviewID";
         $review_deleted=$conn->query($delete_review_query);

         echo '<script>alert("Successfully Deleted!")</script>';
         header("Refresh:0; url=../front-end/account.php");
         //
         // $delete_share_query="DELETE FROM SHARES WHERE ReviewID= $reviewID";
         // $share_deleted=$conn->query($delete_share_query);
?>
