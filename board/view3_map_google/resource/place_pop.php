<?php
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
include_once														"../../../view3.php";
######################################################################################################################################################
$id = $_POST['id'];
$subject = $_POST['subject'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$distance = $_POST['distance'];
?>

<div class="place_modal">
	<p class="place_title b_ff_h"><?=$subject?><?if($distance){?>&nbsp;&nbsp;<span>[<?=$distance?>km]</span><?}?></p>
	<div class="place_cont">
		<p class="place_addr b_ff_m"><?=$address?></p>
		<a href="<?=$root?>/board/index.php?board=map_01&amp;type=view&amp;sca=all&amp;idx=<?=$id?>" class="more_btn_wrap b_ff_m">자세히 보기</a>
	</div>
</div>