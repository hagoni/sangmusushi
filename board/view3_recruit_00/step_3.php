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
        <div class="apply_step3">
            <p class="req t_right"><span class="remark">필수 입력 항목입니다.</span></p>
            <div class="changeable-field-container layer layer1">
                <p class="lyr_tit">해외경험</p>
                <div class="text_cont">
                    <input type="hidden" name="overseas" value="">
                    <fieldset class="proxy-field-container" data-field="overseas" data-type="json">
                        <ul class="changeable-field-lists">
                            <li class="changeable-field-list">
                                <!-- 체류국가 -->
                                <div class="input_common over_h">
                                    <label>체류국가</label>
                                    <div class="input_area">
                                        <input type="text" class="proxy-field" data-key="key1">
                                    </div>
                                </div>
                                <!-- 구사언어 -->
                                <div class="input_common over_h">
                                    <label>구사언어</label>
                                    <div class="input_area">
                                        <input type="text" class="proxy-field" data-key="key2">
                                    </div>
                                </div>
                                <!-- 기간 -->
                                <div class="input_common input_date input_date2 over_h">
                                    <label>기간</label>
                                    <div class="input_area">
                                        <input type="text" class="datepicker-field proxy-field" readonly data-key="key3">
                                        <button type="button" class="btn-datepicker cal abs"></button>
                                    </div>
                                    <span class="sym">~</span>
                                    <div class="input_area">
                                        <input type="text" class="datepicker-field proxy-field" readonly data-key="key4">
                                        <button type="button" class="btn-datepicker cal abs"></button>
                                    </div>
                                </div>
                                <!-- 내용 -->
                                <div class="input_common input_w100 over_h">
                                    <label>내용</label>
                                    <div class="input_area">
                                        <input type="text" class="proxy-field" data-key="key5">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </fieldset>
                </div>
                <div class="add_field text_cont over_h">
                    <button class="field-add add_btn f_right">+ &nbsp;항목추가</button>
                </div>
            </div>
            <div class="changeable-field-container layer layer2">
                <p class="lyr_tit">어학사항</p>
                <div class="text_cont">
                    <input type="hidden" name="language" value="">
                    <fieldset class="proxy-field-container" data-field="language" data-type="json">
                        <ul class="changeable-field-lists">
                            <li class="changeable-field-list">
                                <div class="input_wrap over_h">
                                    <div class="f_left">
                                        <!-- 외국어명 -->
                                        <div class="input_common over_h">
                                            <label>외국어명</label>
                                            <div class="input_area">
                                                <input type="text" class="proxy-field" data-key="key1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f_right">
                                        <!-- 어학종류 -->
                                        <div class="input_common over_h">
                                            <label>어학종류</label>
                                            <div class="input_area">
                                                <input type="text" class="proxy-field" data-key="key2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input_wrap over_h">
                                    <div class="f_left">
                                        <!-- 취득점수 -->
                                        <div class="input_common over_h">
                                            <label>취득점수</label>
                                            <div class="input_area">
                                                <input type="text" class="proxy-field" data-key="key3">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f_right">
                                        <!-- 취득급수 -->
                                        <div class="input_common over_h">
                                            <label>취득급수</label>
                                            <div class="input_area">
                                                <input type="text" class="proxy-field" data-key="key4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 내용 -->
                                <div class="input_common input_w100 over_h">
                                    <label>내용</label>
                                    <div class="input_area">
                                        <input type="text" class="proxy-field" data-key="key5">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </fieldset>
                </div>
                <div class="add_field text_cont over_h">
                    <button class="field-add add_btn f_right">+ &nbsp;항목추가</button>
                </div>
            </div>
            <div class="changeable-field-container layer layer3">
                <p class="lyr_tit">자격/면허사항</p>
                <div class="text_cont">
                    <input type="hidden" name="license" value="">
                    <fieldset class="proxy-field-container" data-field="license" data-type="json">
                        <ul class="changeable-field-lists">
                            <li class="changeable-field-list">
                                <!-- 취득일/수상일 -->
                                <div class="input_common input_date over_h">
                                   <label>취득일/수상일</label>
                                   <div class="input_area">
                                       <input type="text" class="datepicker-field proxy-field" readonly data-key="key1">
                                       <button type="button" class="btn-datepicker cal abs"></button>
                                   </div>
                               </div>
                                <div class="input_wrap over_h">
                                    <div class="f_left">
                                        <!-- 자격명칭 -->
                                        <div class="input_common over_h">
                                            <label>자격명칭</label>
                                            <div class="input_area">
                                              <input type="text" class="proxy-field" data-key="key2">
                                            </div>
                                       </div>
                                    </div>
                                    <div class="f_right">
                                        <!-- 취득급수 -->
                                        <div class="input_common over_h">
                                            <label>취득급수</label>
                                            <div class="input_area">
                                                <input type="text" class="proxy-field" data-key="key3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 내용 -->
                                <div class="input_common input_w100 over_h">
                                    <label for="acqCont">내용</label>
                                    <div class="input_area">
                                        <input type="text" class="proxy-field" data-key="key4">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </fieldset>
                </div>
                <div class="add_field text_cont over_h">
                    <button class="field-add add_btn f_right">+ &nbsp;항목추가</button>
                </div>
            </div>
            <div class="apply_btns over_h">
                <a href="#none" class="apply_prev f_left" data-step="2">STEP2<em>학력/경력</em></a>
                <a href="#none" class="apply_next f_right" data-step="4">STEP4<em>자기소개</em></a>
            </div>
        </div>
        <!-- //STEP1 end -->
    </div>
</div>
<!-- //apply_steps end -->