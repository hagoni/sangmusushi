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
        <div class="apply_step1">
            <p class="req t_right"><span class="remark">필수 입력 항목입니다.</span></p>
            <div class="layer layer1">
                <p class="lyr_tit">개인정보</p>
                <div class="text_cont">
                    <fieldset>
                        <!-- 사진첨부 -->
                        <div class="input_file_area fs_def">
                            <div class="file_thumb remark rel">
                                <span>+ &nbsp;사진등록</span>
                                <div id="imgPreview" class="thumbnail over_h abs"></div>
                            </div>
                            <div class="input_file rel">
                                <input type="file" name="file[0]" id="file00" required accept="image/*">
                                <label for="file00">사진 첨부하기</label>
                            </div>
                        </div>
                        <!-- 지원구분 -->
                        <div class="input_common m_t30 clearfix">
                            <label for="selType" class="remark">지원구분</label>
                            <div class="input_area">
                                <select name="type" id="selType" required>
                                    <option value="">선택</option>
                                    <option value="신입">신입</option>
                                    <option value="경력">경력</option>
                                </select>
                            </div>
                        </div>
                        <!-- 희망연봉 -->
                        <div class="input_common clearfix">
                            <label for="selWage">희망연봉</label>
                            <div class="input_area">
                                <input name="wage" id="selWage">
                            </div>
                        </div>
                        <div class="input_wrap clearfix">
                            <div class="f_left">
                                <!-- 국적 -->
                                <div class="input_common over_h">
                                    <label for="nationality">국적</label>
                                    <div class="input_area">
                                        <input type="text" name="nationality">
                                    </div>
                                </div>
                                <!-- 성별 -->
                                <div class="input_common clearfix">
                                    <label for="selGen" class="remark">성별</label>
                                    <div class="input_area">
                                        <select name="gender" id="selGen" required>
                                            <option value="">선택</option>
                                            <option value="남자">남자</option>
                                            <option value="여자">여자</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="f_right">
                                <!-- 한글이름 -->
                                <div class="input_common clearfix">
                                    <label for="krName" class="remark">한글이름</label>
                                    <div class="input_area">
                                        <input type="text" name="name_kr" id="krName" required>
                                    </div>
                                </div>
                                <!-- 영문이름 -->
                                <div class="input_common clearfix">
                                    <label for="enName">영문이름</label>
                                    <div class="input_area">
                                        <input type="text" name="name_en" id="enName">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 생년월일 -->
                        <div class="input_common input_date clearfix">
                            <label for="dob" class="remark">생년월일</label>
                            <div class="input_area">
                                <input type="text" name="dob" id="dob" class="datepicker-field" required readonly data-def="-28">
                                <button type="button" class="btn-datepicker cal abs"></button>
                            </div>
                        </div>
                        <!-- 이메일 -->
                        <div class="proxy-field-container input_common input_email clearfix" data-field="email" data-type="multiple-text" data-delimiter="@">
                            <input type="hidden" name="email" value="">
                            <label>이메일</label>
                            <div class="input_area">
                                <input type="text" class="proxy-field">
                            </div>
                            <span class="sym">&#64;</span>
                            <div class="input_area">
                                <input type="text" class="proxy-field">
                            </div>
                        </div>
                        <div class="proxy-field-container input_common input_hp clearfix" data-field="tel" data-type="multiple-text" data-delimiter="">
                            <input type="hidden" name="tel" value="">
                            <label class="remark">연락처</label>
                            <div class="input_area">
                                <input type="text" class="proxy-field" required>
                            </div>
                            <span class="sym">-</span>
                            <div class="input_area">
                                <input type="text" class="proxy-field" required>
                            </div>
                            <span class="sym">-</span>
                            <div class="input_area">
                                <input type="text" class="proxy-field" required>
                            </div>
                        </div>
                        <!-- 주소 -->
                        <div class="input_common input_address clearfix">
                            <label class="remark">주소</label>
                            <div class="input_area">
                                <input type="text" name="zipcode" id="zipcode" class="p_code" required>
                                <button type="button" class="addr_search find">우편번호 찾기</button>
                                <span class="footnote">실제 거주하시는 주소를 입력해주시기 바랍니다.</span>
                                <input type="text" name="addr_01" id="addr_01" class="m_t20 m_b20" required readonly><br>
                                <input type="text" name="addr_02" id="addr_02">
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="layer layer2">
                <p class="lyr_tit">병역사항</p>
                <div class="text_cont">
                    <fieldset class="proxy-field-container" data-field="military" data-type="json">
                        <input type="hidden" name="military" value="">
                        <!-- 병역사항 -->
                        <div class="input_common over_h">
                            <label for="milType">병역사항</label>
                            <div class="input_area">
                                <select id="milType" class="proxy-field" data-key="key1">
                                    <option value="">선택</option>
                                    <option value="필">필</option>
                                    <option value="미필">미필</option>
                                    <option value="면제">면제</option>
                                    <option value="전역 예정">전역 예정</option>
                                    <option value="해당사항 없음">해당사항 없음</option>
                                </select>
                            </div>
                        </div>
                        <div class="input_wrap over_h">
                            <div class="f_left">
                                <!-- 군별 -->
                                <div class="input_common over_h">
                                    <label for="milGroup">군별</label>
                                    <div class="input_area">
                                        <input type="text" id="milGroup" class="proxy-field" data-key="key2">
                                    </div>
                                </div>
                            </div>
                            <div class="f_right">
                                <!-- 최종계급 -->
                                <div class="input_common over_h">
                                    <label for="milRank">최종계급</label>
                                    <div class="input_area">
                                        <input type="text" id="milRank" class="proxy-field" data-key="key3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 복무기간 -->
                        <div class="input_common input_date input_date2 over_h">
                            <label>복무기간</label>
                            <div class="input_area">
                                <input type="text" id="mil_period1" class="datepicker-field proxy-field" readonly data-key="key4">
                                <button type="button" class="btn-datepicker cal abs"></button>
                            </div>
                            <span class="sym">~</span>
                            <div class="input_area">
                                <input type="text" id="mil_period2" class="datepicker-field proxy-field" readonly data-key="key5">
                                <button type="button" class="btn-datepicker cal abs"></button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="layer layer3">
                <p class="lyr_tit">보훈사항</p>
                <div class="text_cont">
                    <fieldset class="clearFix">
                        <div class="input_radio f_left">
                            <input type="radio" name="veteran" id="vetFalse" value="0" checked>
                            <label for="vetFalse">비대상</label>
                        </div>
                        <div class="input_radio f_left">
                            <input type="radio" name="veteran" id="vetTrue" value="1">
                            <label for="vetTrue">대상</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="layer layer4">
                <p class="lyr_tit">장애사항</p>
                <div class="text_cont">
                    <fieldset class="clearFix">
                        <div class="input_radio f_left">
                            <input type="radio" name="disability" id="disFalse" value="0" checked>
                            <label for="disFalse">비대상</label>
                        </div>
                        <div class="input_radio f_left">
                            <input type="radio" name="disability" id="disTrue" value="1">
                            <label for="disTrue">대상</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="apply_btns over_h">
                <a href="#none" class="apply_next f_right" data-step="2">STEP2<em>학력/경력</em></a>
            </div>
        </div>
        <!-- //STEP1 end -->
    </div>
</div>
<!-- //apply_steps end -->