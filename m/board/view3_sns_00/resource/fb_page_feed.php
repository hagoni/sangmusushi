<?php
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../../view3.php";
######################################################################################################################################################
$pageId = $_POST['pageId'];
$cover = $_POST['cover'];
$name = nl2br(str_replace('\\\'', '\'', $_POST['name']));
$textLimit = $_POST['textLimit'];
$feed = $_POST['feed'];
for($i=0; $i<count($feed); $i++) {
	$time = date('Y.m.d', strtotime($feed[$i][created_time]));
	$desc = preg_replace('/(http|https|ftp|mms):\/\/[0-9a-z-]+(\.[_0-9a-z-]+)+(:[0-9]{2,4})?\/?([\.~_0-9a-z-]+\/?)*(\S+\.[_0-9a-z]+)?(\?[_0-9a-z#%&=\-\+]+)*/i', '<a href="\\0" target="_blank">\\0</a>', $feed[$i][message]);
	if($textLimit == 'false') $desc;
	else $desc = cut($desc, $textLimit, '...');
?>
	<li class="grid-item">
		<div class="fb_head">
			<div class="col1 f_left">
				<img src="<?=$cover?>" alt="" />
			</div>
			<div class="col2 f_left">
				<p class="row1 b_fs_l b_ff_h"><?=$name?></p>
				<p class="row2 b_fs_m b_c_l"><?=$time?></p>
			</div>
		</div>
		<p class="fb_text b_fs_m b_lh_m b_c_l"><?=$desc?></p>
		<div class="fb_link t_right">
			<a href="<?=$feed[$i][link]?>" target="_blank" class="b_fs_m">more...</a>
		</div>
<?
	if($feed[$i][photo]) {
?>
		<div class="fb_img">
			<img src="<?=$feed[$i][photo]?>" alt="" />
		</div>
<?
	}
?>
	</li>
<?
}
?>