<?php
require 'functions/functions.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header("location:home.php");
}
session_destroy();
session_start();
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css?family=Niramit:400,500,600,700|Oswald:400,500,600,700" rel="stylesheet">
    
    <link rel="stylesheet" href="stylesheets/stylesign.css">
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico">
    
    
</head>
<body>
    <header>
        <a href="index.php" class="logo"><img src="images/logo.png" class="logoimg"> </a>
    </header>

    
    <main>
        
                    <form class="box" method="post" onsubmit="return validateRegister()" >
                        <h1>SIGN UP</h1>
                        <p class="other"> Already have an account? Click <a href="login.php">here</a> to log in!</p>
                        <h2>Compulsory: </h2>
                        
                        
                        <label>First Name<span>*</span></label><br>
                        <input type="text" name="userfirstname" id="userfirstname">
                        <div class="required"></div>
                        <br>
                        
                        <label>Last Name<span>*</span></label><br>
                        <input type="text" name="userlastname" id="userlastname">
                        <div class="required"></div>
                        <br>
                        
                        <label>Nickname</label><br>
                        <input type="text" name="usernickname" id="usernickname">
                        <div class="required"></div>
                        <br>
                       
                        <label>Password<span>*</span></label><br>
                        <input type="password" name="userpass" id="userpass">
                        <div class="required"></div>
                        <br>
                        
                        <label>Confirm Password<span>*</span></label><br>
                        <input type="password" name="userpassconfirm" id="userpassconfirm">
                        <div class="required"></div>
                        <br>
                        
                        <label>Email<span>*</span></label><br>
                        <input type="text" name="useremail" id="useremail">
                        <div class="required"></div>
                        <br>
                        
                        Birth Date<span>*</span><br>
                        <select name="selectday">

                        <?php
                        for($i=1; $i<=31; $i++){
                            echo '<option value="'. $i .'">'. $i .'</option>';
                        }
                        ?>
                        </select>
                        <select name="selectmonth">
                        <?php
                        echo '<option value="1">January</option>';
                        echo '<option value="2">February</option>';
                        echo '<option value="3">March</option>';
                        echo '<option value="4">April</option>';
                        echo '<option value="5">May</option>';
                        echo '<option value="6">June</option>';
                        echo '<option value="7">July</option>';
                        echo '<option value="8">August</option>';
                        echo '<option value="9">September</option>';
                        echo '<option value="10">October</option>';
                        echo '<option value="11">Novemeber</option>';
                        echo '<option value="12">December</option>';
                        ?>
                        </select>
                        <select name="selectyear">
                        <?php
                        for($i=2017; $i>=1900; $i--){
                            if($i == 1996){
                                echo '<option value="'. $i .'" selected>'. $i .'</option>';
                            }
                            echo '<option value="'. $i .'">'. $i .'</option>';
                        }
                        ?>
                        </select>
                        <br><br>
                        
                        <input type="radio" name="usergender" value="M" id="malegender" class="usergender">
                        <label>Male</label>
                        <input type="radio" name="usergender" value="F" id="femalegender" class="usergender">
                        <label>Female</label>
                        <div class="required"></div>
                        <br>
                        
                        <label>Hometown</label><br>
                        <input type="text" name="userhometown" id="userhometown">
                        <br>
                        
                        <h2>Optional:</h2>
                        
                        
                        <input type="radio" name="userstatus" value="S" id="singlestatus">
                        <label>Single</label>
                        <input type="radio" name="userstatus" value="E" id="engagedstatus">
                        <label>Engaged</label>
                        <input type="radio" name="userstatus" value="M" id="marriedstatus">
                        <label>Married</label>
                        <br><br>
                        
                        <label>About Me</label><br>
                        <textarea rows="12" name="userabout" id="userabout"></textarea>
                        <br><br>
                        <input type="submit" value="Create Account" name="register" class="signbutton">
                    </form>
                
    </main>

    <script src="resources/js/main.js"></script>
</body>
</html>

<?php
$conn = connect();
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A form is posted
    /*if (isset($_POST['login'])) { // Login process
        $useremail = $_POST['useremail'];
        $userpass = md5($_POST['userpass']);
        $query = mysqli_query($conn, "SELECT * FROM users WHERE user_email = '$useremail' AND user_password = '$userpass'");
        if($query){
            if(mysqli_num_rows($query) == 1) {
                $row = mysqli_fetch_assoc($query);
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row['user_firstname'] . " " . $row['user_lastname'];
                header("location:home.php");
            }
            else {
                ?> <script>
                    document.getElementsByClassName("required")[0].innerHTML = "Invalid Login Credentials.";
                    document.getElementsByClassName("required")[1].innerHTML = "Invalid Login Credentials.";
                </script> <?php
            }
        } else{
            echo mysqli_error($conn);
        }
    }*/
    if (isset($_POST['register'])) { // Register process
        // Retrieve Data
        $userfirstname = $_POST['userfirstname'];
        $userlastname = $_POST['userlastname'];
        $usernickname = $_POST['usernickname'];
        $userpassword = md5($_POST['userpass']);
        $useremail = $_POST['useremail'];
        $userbirthdate = $_POST['selectyear'] . '-' . $_POST['selectmonth'] . '-' . $_POST['selectday'];
        $usergender = $_POST['usergender'];
        $userhometown = $_POST['userhometown'];
        $userabout = $_POST['userabout'];
        if (isset($_POST['userstatus'])){
            $userstatus = $_POST['userstatus'];
        }
        else{
            $userstatus = NULL;
        }
        // Check for Some Unique Constraints
        $query = mysqli_query($conn, "SELECT user_nickname, user_email FROM users WHERE user_nickname = '$usernickname' OR user_email = '$useremail'");
        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_assoc($query);
            if($usernickname == $row['user_nickname'] && !empty($usernickname)){
                ?> <script>
                document.getElementsByClassName("required")[4].innerHTML = "This Nickname already exists.";
                </script> <?php
            }
            if($useremail == $row['user_email']){
                ?> <script>
                document.getElementsByClassName("required")[7].innerHTML = "This Email already exists.";
                </script> <?php
            }
        }
        // Insert Data
        $sql = "INSERT INTO users(user_firstname, user_lastname, user_nickname, user_password, user_email, user_gender, user_birthdate, user_status, user_about, user_hometown)
                VALUES ('$userfirstname', '$userlastname', '$usernickname', '$userpassword', '$useremail', '$usergender', '$userbirthdate', '$userstatus', '$userabout', '$userhometown')";
        $query = mysqli_query($conn, $sql);
        if($query){
            $query = mysqli_query($conn, "SELECT user_id FROM users WHERE user_email = '$useremail'");
            $row = mysqli_fetch_assoc($query);
            $_SESSION['user_id'] = $row['user_id'];
            header("location:home.php");
        }
    }
}
?>



















