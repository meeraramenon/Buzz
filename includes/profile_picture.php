<style>
	.dp{
		border-radius:10px;
	    margin:auto auto;
	}	
</style>



<?php
$target = glob("data/images/profiles/" . $row['user_id'] . ".*");
if($target) {
    echo '<img class="dp" src="' . $target[0] . '" width="' . $width . '" height="' . $height .'">';
} else {
    if($row['user_gender'] == 'M') {
        echo '<img class="dp" src="data/images/profiles/M.jpg" width="' . $width . '" height="' . $height .'">';
    } else if ($row['user_gender'] == 'F') {
        echo '<img class="dp" src="data/images/profiles/F.jpg" width="' . $width . '" height="' . $height .'">';
    }
}
?>
