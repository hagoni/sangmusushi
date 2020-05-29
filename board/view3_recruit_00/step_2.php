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
        <!-- STEP2 start -->
        <div class="apply_step2">
			<p class="req t_right"><span class="remark">필수 입력 항목입니다.</span></p>
            <div class="layer layer1">
                <p class="lyr_tit">최종학력</p>
                <div class="text_cont">
                    <fieldset class="proxy-field-container" data-field="institute" data-type="json">
						<input type="hidden" name="institute" value="">
                        <div class="input_wrap clearfix">
                            <div class="f_left">
                                <!-- 학교명 -->
                                <div class="input_common clearfix">
                                    <label for="institute_name" class="remark">학교명</label>
                                    <div class="input_area">
                                        <input type="text" id="institute_name" class="proxy-field" required data-key="key1">
                                    </div>
                                </div>
                                <!-- 전공 -->
                                <div class="input_common clearfix">
                                    <label for="major" class="remark">전공</label>
                                    <div class="input_area">
                                        <input type="text" id="major" class="proxy-field" required data-key="key2">
                                    </div>
                                </div>
                            </div>
                            <div class="f_right">
                                <!-- 졸업여부 -->
                                <div class="input_common clearfix">
                                    <label for="grStatus" class="remark">졸업여부</label>
                                    <div class="input_area">
                                        <select id="grStatus" class="proxy-field" required data-key="key3">
                                            <option value="">선택</option>
                                            <option value="졸업">졸업</option>
                                            <option value="졸업예정">졸업예정</option>
                                            <option value="중퇴">중퇴</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- 학점/만점 -->
                                <div class="input_common clearfix">
                                    <label class="remark">학점/만점</label>
                                    <div class="input_area divide fs_def">
                                        <input type="text" class="proxy-field" required data-key="key4">
										<span class="bridge">/</span>
										<select class="proxy-field" required data-key="key5">
											<option value="">만점선택</option>
											<option value="4.5">4.5</option>
											<option value="4.3">4.3</option>
											<option value="4.0">4.0</option>
										</select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 재학기간 -->
                        <div class="input_common input_date input_date2 clearfix">
                            <label>재학기간</label>
                            <div class="input_area">
                                <input type="text" class="datepicker-field proxy-field" readonly data-key="key6">
                                <button class="btn-datepicker cal abs"></button>
                            </div>
                            <span class="sym">~</span>
                            <div class="input_area">
                                <input type="text" class="datepicker-field proxy-field" readonly data-key="key7">
                                <button class="btn-datepicker cal abs"></button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="changeable-field-container layer layer2">
                <p class="lyr_tit">경력사항</p>
                <div class="text_cont">
					<input type="hidden" name="career" value="">
                    <fieldset class="proxy-field-container" data-field="career" data-type="json">
						<ul class="changeable-field-lists">
							<li class="changeable-field-list">
								<!-- 회사명 -->
		                        <div class="input_common clearfix">
		                            <label>회사명</label>
		                            <div class="input_area">
		                                <input type="text" class="proxy-field" data-key="key1">
		                            </div>
		                        </div>
		                        <div class="input_wrap clearfix">
		                            <div class="f_left">
		                                <!-- 부서/직급/직책 -->
		                                <div class="input_common clearfix">
		                                    <label>부서/직급</label>
											<div class="input_area divide fs_def">
		                                        <input type="text" class="proxy-field" data-key="key2">
												<span class="bridge">/</span>
												<input type="text" class="proxy-field" data-key="key3">
		                                    </div>
		                                </div>
		                            </div>
		                            <div class="f_right">
		                                <!-- 최종연봉 -->
		                                <div class="input_common clearfix">
		                                    <label>최종연봉</label>
		                                    <div class="input_area extra_case">
		                                        <input type="text" class="proxy-field" data-key="key4"><span class="unit">만원</span>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                        <!-- 담당업무 -->
		                        <div class="input_common input_w100 clearfix">
		                            <label for="assignedTask">담당업무</label>
		                            <div class="input_area">
		                                <input type="text" class="proxy-field" data-key="key5">
		                            </div>
		                        </div>
		                        <!-- 기간 -->
		                        <div class="input_common input_date input_date2 clearfix">
		                            <label>기간</label>
		                            <div class="input_area">
										<input type="text" class="datepicker-field proxy-field" readonly data-key="key6">
	                                    <button type="button" class="btn-datepicker cal abs"></button>
		                            </div>
		                            <span class="sym">~</span>
		                            <div class="input_area">
										<input type="text" class="datepicker-field proxy-field" readonly data-key="key7">
	                                    <button type="button" class="btn-datepicker cal abs"></button>
		                            </div>
		                        </div>
							</li>
						</ul>
                    </fieldset>
                </div>
                <div class="add_field text_cont over_h">
                    <button type="button" class="field-add add_btn f_right">+ &nbsp;항목추가</button>
                </div>
            </div>
            <div class="apply_btns over_h">
                <a href="#none" class="apply_prev f_left" data-step="1">STEP1<em>개인정보</em></a>
                <a href="#none" class="apply_next f_right" data-step="3">STEP3<em>외국어/자격</em></a>
            </div>
        </div>
		<!-- //STEP2 end -->
	</div>
</div>
<!-- //apply_steps end -->