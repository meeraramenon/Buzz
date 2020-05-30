

<?php
require 'functions/functions.php';
session_start();
ob_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
// Establish Database Connection
$conn = connect();
?>

<?php
if(isset($_GET['id']) && $_GET['id'] != $_SESSION['user_id']) {
    $current_id = $_GET['id'];
    $flag = 1;
} else {
    $current_id = $_SESSION['user_id'];
    $flag = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Niramit:400,500,600,700|Oswald:400,500,600,700" rel="stylesheet">
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="stylesheets/profilestyle.css">

    <style>

    

    .container{
        width:1400px;
    background-color:rgba(255,255,255,70%);
  
    border-radius:30px;
    margin:0 auto;
    overflow:hidden;
    margin-bottom:30px;
    margin-top:10px;
    }

    h1{
        font-family:Oswald;
        text-align:center;
        text-decoration: underline dotted red;
        margin-bottom:20px;
    }

    .profile{
        float:left;
        text-transform: capitalize;
      
        display:block;
        margin-left:100px;
        line-height: 20px;
    }

    .changedp{
        
        margin:20px auto;
        margin-left: 40px;        
        background-color: rgba(255,255,255,50%);
        text-align:center;
        padding:10px;
    }


    .changeprofile{
        float:left;

    }

    .profile form{
        float:left;


    }    
    .posts{
        float:right;
        width:900px;
        margin-right:70px;
        margin-bottom:30px;
    }


    .phone{
        float:left;
        text-align:center;
        margin-top:10px;
        text-align:center;
        margin-bottom:20px;

    }    

    .nopost{
        font-family: Oswald;
        margin-left:200px;
        margin-bottom: 50px;
    }
    .phone form{
        position:center;
    }

</style>

    
</head>

<body>
        <div class="container">
            <?php include 'includes/navbar.php'; ?>
            <h1>Profile</h1>
            <?php
            $postsql;

            echo '<div class="posts">';
            if($flag == 0) { // Your Own Profile
                $postsql = "SELECT posts.post_caption, posts.post_time, users.user_firstname, users.user_lastname,
                                    posts.post_public, users.user_id, users.user_gender, users.user_nickname,
                                    users.user_birthdate, users.user_hometown, users.user_status, users.user_about,
                                    posts.post_id
                            FROM posts
                            JOIN users
                            ON users.user_id = posts.post_by
                            WHERE posts.post_by = $current_id
                            ORDER BY posts.post_time DESC";
                $profilesql = "SELECT users.user_id, users.user_gender, users.user_hometown, users.user_status, users.user_birthdate,
                                     users.user_firstname, users.user_lastname
                              FROM users
                              WHERE users.user_id = $current_id";
                $profilequery = mysqli_query($conn, $profilesql);
            } else { // Another Profile ---> Retrieve User data and friendship status
                $profilesql = "SELECT users.user_id, users.user_gender, users.user_hometown, users.user_status, users.user_birthdate,
                                        users.user_firstname, users.user_lastname, userfriends.friendship_status
                                FROM users
                                LEFT JOIN (
                                    SELECT friendship.user1_id AS user_id, friendship.friendship_status
                                    FROM friendship
                                    WHERE friendship.user1_id = $current_id AND friendship.user2_id = {$_SESSION['user_id']}
                                    UNION
                                    SELECT friendship.user2_id AS user_id, friendship.friendship_status
                                    FROM friendship
                                    WHERE friendship.user1_id = {$_SESSION['user_id']} AND friendship.user2_id = $current_id
                                ) userfriends
                                ON userfriends.user_id = users.user_id
                                WHERE users.user_id = $current_id";
                $profilequery = mysqli_query($conn, $profilesql);
                $row = mysqli_fetch_assoc($profilequery);
                mysqli_data_seek($profilequery,0);
                if(isset($row['friendship_status'])){ // Either a friend or requested as a friend
                    if($row['friendship_status'] == 1){ // Friend
                        $postsql = "SELECT posts.post_caption, posts.post_time, users.user_firstname, users.user_lastname,
                                            posts.post_public, users.user_id, users.user_gender, users.user_nickname,
                                            users.user_birthdate, users.user_hometown, users.user_status, users.user_about,
                                            posts.post_id
                                    FROM posts
                                    JOIN users
                                    ON users.user_id = posts.post_by
                                    WHERE posts.post_by = $current_id
                                    ORDER BY posts.post_time DESC";
                    }
                    else if($row['friendship_status'] == 0){ // Requested as a Friend
                        $postsql = "SELECT posts.post_caption, posts.post_time, users.user_firstname, users.user_lastname,
                                            posts.post_public, users.user_id, users.user_gender, users.user_nickname,
                                            users.user_birthdate, users.user_hometown, users.user_status, users.user_about,
                                            posts.post_id
                                    FROM posts
                                    JOIN users
                                    ON users.user_id = posts.post_by
                                    WHERE posts.post_by = $current_id AND posts.post_public = 'Y'
                                    ORDER BY posts.post_time DESC";
                    }
                } else { // Not a friend
                    $postsql = "SELECT posts.post_caption, posts.post_time, users.user_firstname, users.user_lastname,
                                        posts.post_public, users.user_id, users.user_gender, users.user_nickname,
                                        users.user_birthdate, users.user_hometown, users.user_status, users.user_about,
                                        posts.post_id
                                FROM posts
                                JOIN users
                                ON users.user_id = posts.post_by
                                WHERE posts.post_by = $current_id AND posts.post_public = 'Y'
                                ORDER BY posts.post_time DESC";
                }
            }

            $postquery = mysqli_query($conn, $postsql);
            if($postquery){
                // Posts
                $width = '40px';
                $height = '40px';
                if(mysqli_num_rows($postquery) == 0){ // No Posts
                    if($flag == 0){ // Message shown if it's your own profile
                        echo '<div class="nopost">';
                        echo 'You don\'t have any posts yet';
                        echo '</div>';
                    } else { // Message shown if it's another profile other than you.
                        echo '<div class="post">';
                        echo 'There is no public posts to show.';
                        echo '</div>';
                    }
                    include 'includes/profile.php';
                } else {
                    while($row = mysqli_fetch_assoc($postquery)){
                        include 'includes/post.php';
                    }
                    echo "</div>";
                    // Profile Info
                    echo '<div class="profile dp">';
                    include 'includes/profile.php';
                    echo '</div>';
                    ?>
                    <br>
                    <?php if($flag == 0){?>
                    <div class="profile changedp" align="left">
                        <div class="changeprofile">Change Profile Picture</div>
                        <br>
                        <form action="" method="post" enctype="multipart/form-data">
                            <center>
                                <label class="upload" onchange="showPath()">
                                    <span id="path" style="color: white;">... Browse</span>
                                    <input type="file" name="fileUpload" id="selectedFile">
                                </label>
                            </center>
                            <br>
                            <input type="submit" value="Upload Image" name="profile">
                        </form>
                    </div>
                    <br>
                    <div class="profile phone" align="left">
                        <div class="changeprofile">Add Phone Number</div>
                        <br>
                        <form method="post" onsubmit="return validateNumber()">
                            <div class="phone" align="left">
                                <input type="text" name="number" id="phonenum">
                                <div class="required"></div>
                                <br>
                                <input type="submit" value="Submit" name="phone">
                            </div>
                        </form>
                    </div>
                    <br>
                    <?php } ?>
                    <?php
                }
            }
            ?>
        </div>
</body>
<script>
function showPath(){
    var path = document.getElementById("selectedFile").value;
    path = path.replace(/^.*\\/, "");
    document.getElementById("path").innerHTML = path;
}
function validateNumber(){
    var number = document.getElementById("phonenum").value;
    var required = document.getElementsByClassName("required");
    if(number == ""){
        required[0].innerHTML = "You must type Your Number.";
        return false;
    } else if(isNaN(number)){
        required[0].innerHTML = "Phone Number must contain digits only."
        return false;
    }
    return true;
}
</script>
</html>
<?php include 'functions/upload.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A form is posted
    if (isset($_POST['request'])) { // Send a Friend Request
        $sql3 = "INSERT INTO friendship(user1_id, user2_id, friendship_status)
                 VALUES ({$_SESSION['user_id']}, $current_id, 0)";
        $query3 = mysqli_query($conn, $sql3);
        if(!$query3){
            echo mysqli_error($conn);
        }
    } else if(isset($_POST['remove'])) { // Remove
        $sql3 = "DELETE FROM friendship
                 WHERE ((friendship.user1_id = $current_id AND friendship.user2_id = {$_SESSION['user_id']})
                 OR (friendship.user1_id = {$_SESSION['user_id']} AND friendship.user2_id = $current_id))
                 AND friendship.friendship_status = 1";
        $query3 = mysqli_query($conn, $sql3);
        if(!$query3){
            echo mysqli_error($conn);
        }
    } else if(isset($_POST['phone'])) { // Add a Phone Number to Your Profile
        $sql3 = "INSERT INTO user_phone(user_id, user_phone) VALUES ({$_SESSION['user_id']},{$_POST['number']})";
        $query3 = mysqli_query($conn, $sql3);
        if(!$query3){
            echo mysqli_error($conn);
        }
    }
    sleep(4);
}
?>
