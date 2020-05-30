
<?php

//checks and displays our frnds when we click friends on home page

require 'functions/functions.php';
session_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
// Establish Database Connection
$conn = connect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Friends</title>
    <link href="https://fonts.googleapis.com/css?family=Niramit:400,500,600,700|Oswald:400,500,600,700" rel="stylesheet">
    <style>
   *{
    text-decoration:none;
    
}

.container{
    width:1400px;
    background-color:rgba(255,255,255,70%);
    
    border-radius:30px;
    margin:0 auto;
    overflow:hidden;
    margin-bottom:30px;
    margin-top:10px;
    padding-bottom:30px;

}

body{
    background-image: url("images/pink.gif");
    
}


h2{
    font-family:Oswald;
    font-size:40px;
    text-decoration:underline dotted #eb2f06;
    text-align:center;
    margin:20px auto;
}

.whole{
    font-family:Oswald;
    text-transform:capitalize;
}

    </style>
</head>
<body>
    <div class="container">
        <?php include 'includes/navbar.php'; ?>
        <h2>Your Friends</h2>
        <?php
            echo '<div class="whole">';
            echo '<center>';
            $sql = "SELECT users.user_id, users.user_firstname, users.user_lastname, users.user_gender
                    FROM users
                    JOIN (
                        SELECT friendship.user1_id AS user_id
                        FROM friendship
                        WHERE friendship.user2_id = {$_SESSION['user_id']} AND friendship.friendship_status = 1
                        UNION
                        SELECT friendship.user2_id AS user_id
                        FROM friendship
                        WHERE friendship.user1_id = {$_SESSION['user_id']} AND friendship.friendship_status = 1
                    ) userfriends
                    ON userfriends.user_id = users.user_id";
            $query = mysqli_query($conn, $sql);
            $width = '168px';
            $height = '168px';
            if($query){
                if(mysqli_num_rows($query) == 0){
                    echo '<div class="post">';
                    echo 'You don\'t yet have any friends.';
                    echo '</div>';
                } else {
                    while($row = mysqli_fetch_assoc($query)){
                    echo '<div class="frame">';
                    echo '<center>';
                    include 'includes/profile_picture.php';
                    echo '<br>';
                    echo '<a href="profile.php?id=' . $row['user_id'] . '">' . $row['user_firstname'] . ' ' . $row['user_lastname'] . '</a>';
                    echo '</center>';
                    echo '</div>';
                    }
                }
            }
            echo '</center>';
            echo '</div>';
        ?>
    </div>
</body>
</html>
