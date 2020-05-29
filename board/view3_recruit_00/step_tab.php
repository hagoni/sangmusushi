<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- STEPS GUIDE start -->
<div class="apply_steps steps_guide"<?if(!$step || $step == 0) {echo ' style="display:none"';}?>>
    <ul>
        <li<?if($step == 1){echo ' class="on"';}?>>
            <a href="#none" class="apply_goto" data-step="1">
                <p class="step">STEP 1</p>
                <p class="lyr_tit">인적사항</p>
            </a>
        </li>
        <li<?if($step == 2){echo ' class="on"';}?>>
            <a href="#none" class="apply_goto" data-step="2">
                <p class="step">STEP 2</p>
                <p class="lyr_tit">학력/경력</p>
            </a>
        </li>
        <li<?if($step == 3){echo ' class="on"';}?>>
            <a href="#none" class="apply_goto" data-step="3">
                <p class="step">STEP 3</p>
                <p class="lyr_tit">외국어/자격</p>
            </a>
        </li>
        <li<?if($step == 4){echo ' class="on"';}?>>
            <a href="#none" class="apply_goto" data-step="4">
                <p class="step">STEP 4</p>
                <p class="lyr_tit">자기소개</p>
            </a>
        </li>
    </ul>
</div>
<!-- //STEPS GUIDE end -->