<?php
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../../view3.php";
######################################################################################################################################################
$skinPath = $_POST['skinPath'];
$hashTag = $_POST['hashTag'];
$ignoreCaption = isset($_POST['ignoreCaption'])?array_filter(explode('||',$_POST['ignoreCaption'])):Array();
$feed = $_POST['feed'];
for($i=0; $i<count($feed); $i++) {
	if(count($ignoreCaption)>0){
		$continue = false;
		foreach($ignoreCaption as $caption) if(strpos($feed[$i]['caption'],$caption) !== false) $continue = true;
		if($continue)continue;
	}
?>
    <li style="background-image:url('<?=$feed[$i]['display_src']?>')">
        <a href="https://www.instagram.com/p/<?=$feed[$i]['code']?>" target="_blank">
            <p class="b_fs_m b_c_m"><img src="<?=$skinPath?>/img/ig_heart.png" alt="" />&nbsp;&nbsp;<?=$feed[$i]['likes']['count']?><span>COMMENT</span>&nbsp;&nbsp;<?=$feed[$i]['comments']['count']?></p>
        </a>
    </li>
<?
}
?>