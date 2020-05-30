<link href="https://fonts.googleapis.com/css?family=Niramit:400,500,600,700|Oswald:400,500,600,700" rel="stylesheet">

<style>
  
*{
    text-decoration:none;
    list-style: none;
    margin:0;
    padding:0;
    font-family:Arial;
}
 

.logoimg{
    display:block;
    padding-right:40px;
    padding-left:20px;
    margin:14px 0;
    height:35px;
    float:left;
    text-align:left;
    border-right:3px solid #111;
    
}

.usernav{
    

    width:100%;
    height:60px;
    background-color: #FFF8FE;
}

.usernav ul{


    
    font-size: 15px;


}

.usernav ul li{
    display:inline-block;
    float:left;
    margin-left:10px;
    margin-right:10px;
    color:#111;
    transition:0.2s;
    line-height:60px;
}

.usernav ul li a{
    padding:7px;
    margin-left:3px;
    transition:0.2s;
    font-family:Oswald;
    color:#111;

}

.usernav .img{
    background-color: none;

}




.usernav ul li a:hover{

    background-color:rgba(108,92,230,50%);
    border-radius:10px;
    color:#111;

    
}

.usernav .img:hover{
    background-color:rgba(0,0,0,0%);
}

.usernav ul li a:visited{
    color:#111;

}

.usernav .logout{
    margin-right:40px;

}

.globalsearch{
    line-height: 60px;
    margin-left:60px;
    

}


.globalsearch select{
    
    display: inline-block;

}

.searchform .drop{
    border:0;
    
    
    margin:auto auto;
    text-align:center;
    border:2px solid #fd79a8;
    padding:5px 10px;
    width:120px;
    height:38px;
    outline:none;
    color:#111;
    border-radius: 24px;
    transition:0.25s;
    margin-right:5px;

}

.searchform .drop:focus{
    
    border:2px solid #6c5ce7;
    
}

.searchform .searchbox{
    border:0;
    margin:1px auto;
    text-align:left;
    border:2px solid #fd79a8;
    padding:10px 10px;
    width:300px;
    height:15px;
    outline:none;
    color:#111;
    border-radius: 24px;
    transition:0.25s;
    margin-left:20px;
    margin-right:5px;
}

.searchform .searchbox:focus{
    border:2px solid #6c5ce7;
}


#querybutton{
    border:0;

    background:none;
    display:block;
    margin:13px auto;
    
    text-align:center;
    float:right;
    margin-right:70px;
    height:35px;
    border:2px solid #6c5ce7;
    padding:5px 40px;
    outline:none;
    color:#111;
    
    border-radius: 24px;
    transition:0.25s;
    cursor:pointer;
}

#querybutton:hover{
    background:#6c5ce7;
}




</style>

<div class="usernav">
    <?php
        $sql2 = "SELECT COUNT(*) AS count FROM friendship
                 WHERE friendship.user2_id = {$_SESSION['user_id']} AND friendship.friendship_status = 0"; //know the no. of ppl who are not frnds
        $query2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_assoc($query2);
    ?>
    <ul> <!-- Ensure there are no enter escape characters.-->
        <li><a href="home.php" class="img"><img src="images/logo.png" class="logoimg"></a> </li>
        <li><a href="requests.php">Friend Requests(<?php echo $row['count']?>)</a></li><li><a href="profile.php">Profile</a></li><li><a href="friends.php">Friends</a></li><li><a href="home.php">Home</a></li><li class="logout"><a href="logout.php">Log Out</a></li>
    </ul>
    <div class="globalsearch">
        <form class="searchform" method="get" action="search.php" onsubmit="return validateField()">
          <!--validate checks if any box is left blank-->
           <!-- Ensure there are no enter escape characters.-->
            <select name="location" class="drop">
                <option value="emails">Emails</option>
                <option value="names">Names</option>
                <option value="hometowns">Hometowns</option>
                <option value="posts">Posts</option>
            </select><input class="searchbox" type="text" placeholder="Search" name="query" id="query"><input type="submit" value="Search" id="querybutton">
        </form>
    </div>
</div>

<script>
function validateField(){
    var query = document.getElementById("query");
    var button = document.getElementById("querybutton");
    if(query.value == "") {
        query.placeholder = 'Type something!';
        return false;
    }
    return true;
}
</script>
