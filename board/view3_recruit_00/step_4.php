<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- apply_steps start -->
<div class="apply_steps">
    <div class="inner">
        <!-- STEP1 start -->
        <div class="apply_step4 proxy-field-container" data-field="introduce" data-type="json">
            <input type="hidden" name="introduce" value="">
            <p class="req t_right"><span class="remark">필수 입력 항목입니다.</span></p>
            <div class="layer layer1">
                <p class="lyr_tit">
                    자기소개
                    <!-- <span class="text">지원서 작성 중 30분 동안 미 입력시, 로그아웃 됩니다. 작성에 주의하시기 바랍니다. <br class="m_none">최종 제출 이후로는 수정이 불가합니다.</span> -->
                </p>
                <div class="text_cont">
                    <fieldset>
                        <p class="remark">에스앤피프렌차이즈에 지원한 동기는 무엇이며, 입사 후 어떻게 성장 및 발전해 나갈 것인지를 기술하여 주시기 바랍니다. (1,000자 이내)</p>
                        <textarea class="intro_textarea proxy-field" maxlength="1000" data-key="key1" required></textarea>
                        <p class="text_count t_right"><span class="text-length-notice">0</span> / 1000</p>
                    </fieldset>
                </div>
                <div class="text_cont">
                    <fieldset>
                        <p class="remark">지원하신 직무와 관련하여, 필요한 역량을 갖추기 위해 지금까지 어떠한 노력을 해왔는지 구체적으로 기술하고, 이들을 업무에 어떻게 적용할 것인지 기술하여 주시기 바랍니다. (1,000자 이내)</p>
                        <textarea class="intro_textarea proxy-field" maxlength="1000" data-key="key2" required></textarea>
                        <p class="text_count t_right"><span class="text-length-notice">0</span> / 1000</p>
                    </fieldset>
                </div>
                <div class="text_cont">
                    <fieldset>
                        <p class="remark none">[경력직만 해당]업무와 관련하여, 본인이 이룬 가장 큰 성취에 대하여 기술하여 주시기 바랍니다. (1,000자 이내)</p>
                        <textarea class="intro_textarea proxy-field" maxlength="1000" data-key="key3"></textarea>
                        <p class="text_count t_right"><span class="text-length-notice">0</span> / 1000</p>
                    </fieldset>
                </div>
            </div>
            <div class="apply_btns over_h">
                <a href="#none" class="apply_prev f_left" data-step="3">STEP3<em>외국어/자격</em></a>
                <button type="submit" name="button" class="f_right">제출하기</button>
            </div>
        </div>
        <!-- //STEP1 end -->
    </div>
</div>
<!-- //apply_steps end -->