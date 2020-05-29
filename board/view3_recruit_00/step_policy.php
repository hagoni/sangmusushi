<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<div class="cont_top">
    <div class="inner">
        <h3 class="cont_tit"><em>지원서 작성</em></h3>
        <p class="cont_txt">주식회사 에스앤피프렌차이즈의 모든 구성원이 반듯한 마인드를 바탕으로 글로벌 시장을 이끌어 갈 창조적 인재를 찾고 있습니다.</p>
    </div>
</div>

<!-- recruit_agree start -->
<div class="recruit_agree">
    <div class="inner">
        <div class="apply_agreements">
            <div class="layer layer1">
                <p class="lyr_tit">개인정보 수집 및 이용수칙</p>
                <div class="text_cont">
                    <p class="text">
                        본 채용홈페이지를 통해 제출하는 지원서는 귀하께서 지원서를 제출하는 (주)에스앤피프렌차이즈(이하 채용회사)이 직접 접수하고 관리하며,향후 지원서 관리책임은 채용회사에 있습니다.<br><br>
                        지원자는 아래 개인정보 제공 등에 관해 동의하지 않을 권리가 있습니다. 다만, 지원서를 통해 제공받은 정보는 채용회사의 채용 및 선발에 필수적인 항목으로 해당 정보를 제공받지 못할 경우 회사는 공정한 선발전형을 진행할 수 없습니다. 따라서 아래 개인정보 제공에 대해 동의하지 않는 경우 채용 및 선발전형에 지원이 제한될 수 있습니다. 지원자의 동의 거부 권리 및 동의 거부에 따른 불이익은 아래에 제시되는 모든 동의사항에 해당됩니다.
                    </p>
                </div>
            </div>
            <div class="layer layer2">
                <p class="lyr_tit">개인정보 수집 및 이용에 관한 동의</p>
                <div class="text_cont">
                    <ol>
                        <li>
                            <p class="o_text">1. 수집하는 개인정보 항목</p>
                            <p class="text">
                                사진, 지원구분, 희망연봉, 국적, 성명, 성별, 생년월일, 연락처(이메일, 자택, 휴대전화), 주소(주민등록지, 현주소), <br class="m_none">병역사항(군별, 최종계급, 복무기간), 보훈사항, 장애사항, 최종학력, 경력사항, 해외경험, 어학사항, <br class="m_none">자격/면허사항, 자기소개
                            </p>
                        </li>
                        <li>
                            <p class="o_text">2. 수집 및 이용 목적</p>
                            <p class="text">
                                채용 적합성 판단 및 서류 심사, 면접 등의 근거자료로 활용하며 인력 Pool확보 및 전형단계별 안내와 같은 알림을 위해 사용합니다.
                            </p>
                        </li>
                        <li>
                            <p class="o_text">3. 개인정보의 보유 및 이용 기간</p>
                            <p class="text">
                                지원서상에 작성하신 개인정보는 회사의 인재채용을 위한 인재풀로 활용될 예정으로 채용전형 결과 통보일로부터 1년까지 보관됩니다. 지원자께서 <br class="m_none">삭제를 요청하실 경우 해당 개인정보는 삭제됩니다.<br><br>귀하는 위 개인정보 수집 동의를 거부할 수 있습니다. 다만 개인정보 수집에 동의하지 않을 경우 채용절차가 진행되지 않을 수 있습니다.
                            </p>
                        </li>
                    </ol>
                </div>
                <div class="agree_chk over_h">
                    <fieldset class="agree_field">
                        <div class="input_radio f_left m_r40">
                            <input type="radio" name="agree01" id="agreed01" value="1"<?if($agree01 == 1){echo ' checked';}?>>
                            <label for="agreed01">
                                <span class="chk_ico">
                                    <img src="<?=$skin_path?>/img/chk_ico_off.png" alt="" class="off">
                                    <img src="<?=$skin_path?>/img/chk_ico_on.png" alt="" class="on">
                                </span>
                                본인은 [개인정보 수집 및 이용에 관한 동의]를 <span class="m_block">잘 읽어보았으며 내용에 동의합니다.</span>
                            </label>
                        </div>
                        <div class="input_radio f_left">
                            <input type="radio" name="agree01" id="agreed_n01" value="0"<?if(!$agree01 || $agree01 == 0){echo ' checked';}?>>
                            <label for="agreed_n01">
                                <span class="chk_ico">
                                    <img src="<?=$skin_path?>/img/chk_ico_off.png" alt="" class="off">
                                    <img src="<?=$skin_path?>/img/chk_ico_on.png" alt="" class="on">
                                </span>
                                동의안함
                            </label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="layer layer3">
                <p class="lyr_tit">민감정보 수집 및 이용에 관한 동의</p>
                <div class="text_cont">
                    <ol>
                        <li>
                            <p class="o_text">​1. 수집하는 민감정보 항목</p>
                            <p class="text">
                                병역사항(군별, 최종계급, 복무기간), 보훈사항, 장애사항, 최종학력, 경력사항, 해외경험, 어학사항, 자격/면허사항, 자기소개
                            </p>
                        </li>
                        <li>
                            <p class="o_text">2. 수집 및 이용 목적</p>
                            <p class="text">
                                채용 적합성 판단 및 서류 심사, 면접 등의 근거자료로 활용하며 인력 Pool확보 및 전형단계별 안내와 같은 알림을 위해 사용합니다.
                            </p>
                        </li>
                        <li>
                            <p class="o_text">3. 민감정보의 보유 및 이용 기간</p>
                            <p class="text">
                                지원서상에 작성하신 민감정보는 회사의 인재채용을 위한 인재풀로 활용될 예정으로 채용전형 결과 통보일로부터 1년까지 보관됩니다.<br>지원자께서 삭제를 요청하실 경우 해당 민감정보는 삭제됩니다.<br><br>귀하는 위 민감정보 수집 동의를 거부할 수 있습니다. 다만 수집 동의에 거부시 해당 정보는 입사여부결정 및 직급, 연봉 책정시 고려 대상이 되지 <br class="m_none">않습니다. 병역사항에 관한 기재가 없을 시 명백한 면제사유가 없는 한 향후 군 복무가 필요한 미필로 간주될 수 있습니다.
                            </p>
                        </li>
                    </ol>
                </div>
                <div class="agree_chk over_h">
                    <fieldset class="agree_field">
                        <div class="input_radio f_left m_r40">
                            <input type="radio" name="agree02" id="agreed02" value="1"<?if($agree02 == 1){echo ' checked';}?>>
                            <label for="agreed02">
                                <span class="chk_ico">
                                    <img src="<?=$skin_path?>/img/chk_ico_off.png" alt="" class="off">
                                    <img src="<?=$skin_path?>/img/chk_ico_on.png" alt="" class="on">
                                </span>
                                본인은 [민감정보 수집 및 이용에 관한 동의]를 <span class="m_block">잘 읽어보았으며 내용에 동의합니다.</span>
                            </label>
                        </div>
                        <div class="input_radio f_left">
                            <input type="radio" name="agree02" id="agreed_n02" value="0"<?if(!$agree02 || $agree02 == 0){echo ' checked';}?>>
                            <label for="agreed_n02">
                                <span class="chk_ico">
                                    <img src="<?=$skin_path?>/img/chk_ico_off.png" alt="" class="off">
                                    <img src="<?=$skin_path?>/img/chk_ico_on.png" alt="" class="on">
                                </span>
                                동의안함
                            </label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="apply_btns over_h">
                <fieldset class="agree_all f_left">
                    <input type="checkbox" id="agreeAll">
                    <label for="agreeAll">
                        <span class="chk_ico">
                            <img src="<?=$skin_path?>/img/chk_ico_off.png" alt="" class="off">
                            <img src="<?=$skin_path?>/img/chk_ico_on.png" alt="" class="on">
                        </span>
                        위의 내용에 모두 동의합니다.
                    </label>
                </fieldset>
                <a href="#none" class="apply_next f_right" data-step="1">다음</a>
            </div>
        </div>
    </div>
</div>
<!-- //recruit_agree end -->