<?php
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
include_once														"../../../../view3.php";
######################################################################################################################################################
$id = $_POST['id'];
$subject = $_POST['subject'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$distance = $_POST['distance'];
?>

<div class="place_modal">
	<p class="place_title b_ff_h ellipsis"><?=$subject?>&nbsp;&nbsp;<span>[<?=$distance?>km]</span></p>
	<div class="place_cont">
		<p class="place_addr b_ff_m"><?=$address?></p>
		<a href="#none" class="more_btn_wrap b_ff_m anchor-location-pop" data-idx="<?=$id?>">자세히 보기</a>
	</div>
</div>