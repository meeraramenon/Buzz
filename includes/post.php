<link href="https://fonts.googleapis.com/css?family=Niramit:400,500,600,700|Oswald:400,500,600,700" rel="stylesheet">
<style>

	*{
		font-family:Oswald;

	}

	.post{
		margin:10px;
		padding:15px;
		background-color:rgba(255,255,255,50%);
		border-radius:20px;

	}


	.postedtime{
		float:right;
		color:#a4b0be;
		font-size:15px;

	}

	.public{
		float:right;
		color:grey;
	}

   
   .profilelink{
   	text-transform: capitalize;
   	margin-left: 10px;
   	line-height:40px;
   	padding-bottom:20px;
    vertical-align: top;
    color:#82589F;
   }

   .profilelink:visited{
    color:#82589F;
   }

   .caption{
   	margin-left:30px;
   }
	
</style>


<?php
echo '<div class="post">';
	if($row['post_public'] == 'Y') {
	    echo '<p class="public">';
	    echo 'Public';
	}else {
	    echo '<p class="public">';
	    echo 'Private';
	}
	echo '<br>';
	echo '<span class="postedtime">' . $row['post_time'] . '</span>';
	echo '</p>';
	echo '<div class="name">';
	include 'profile_picture.php';
	echo '<a class="profilelink" href="profile.php?id=' . $row['user_id'] .'">' . $row['user_firstname'] . ' ' . $row['user_lastname'] . '<a>';
	echo'</div>';
	echo '<br>';
	echo '<p class="caption">' . $row['post_caption'] . '</p>';
	echo '<center>';
	$target = glob("data/images/posts/" . $row['post_id'] . ".*");
	if($target) {
	    echo '<img src="' . $target[0] . '" style="max-width:580px">';
	    echo '<br><br>';
	}
	echo '</center>';
echo '</div>';
?>
