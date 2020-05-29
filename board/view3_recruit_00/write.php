<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
foreach($_SESSION['data'] as $key => $val) {
    ${$key} = $val;
}
?>

<link rel="stylesheet" href="/board/<?=$view3_skin;?>/css/iframe_mode.css?<?=$time;?>">

<link rel="stylesheet" href="<?=$root?>/plug_in/jquery_ui/jquery-ui-1.12.1.min.css?<?=$time?>">
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="<?=$root?>/plug_in/jquery_ui/jquery-ui-1.12.1.min.js"></script>
<script src="<?=$skin_path?>/js/recruit.js?<?=$time?>"></script>

<form name="apply-form" id="applyApplication" method="post" action="<?=BOARD.'/'.$view3_skin?>/writeAction.php" enctype="multipart/form-data" onsubmit="return false;">
    <input type="hidden" name="board" value="recruit_data">
    <input type="hidden" name="p_idx" value="<?=$_REQUEST['idx']?>">
    <input type="hidden" name="url" value="<?=SELF.'?'.$path_list?>">
    <input type="hidden" name="figure" value="">
    <input type="hidden" name="step" value="<?=$step ? $step : 0?>">
    <?include_once('step_tab.php');?>
    <ul class="apply-steps-container">
        <li class="apply-steps"<?if(!$step || $step == 0) {echo ' style="display:block"';}?> data-step="0">
            <?include_once('step_policy.php');?>
        </li>
        <li class="apply-steps"<?if($step == 1) {echo ' style="display:block"';}?> data-step="1">
            <?include_once('step_1.php');?>
        </li>
        <li class="apply-steps"<?if($step == 2) {echo ' style="display:block"';}?> data-step="2">
            <?include_once('step_2.php');?>
        </li>
        <li class="apply-steps"<?if($step == 3) {echo ' style="display:block"';}?> data-step="3">
            <?include_once('step_3.php');?>
        </li>
        <li class="apply-steps"<?if($step == 4) {echo ' style="display:block"';}?> data-step="4">
            <?include_once('step_4.php');?>
        </li>
    </ul>
</form>