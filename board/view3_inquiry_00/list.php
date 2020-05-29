<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
if($view3_sca != '1n1_01' && $view3_sca != 'jungbo_01' && $view3_sca != 'customer_01') {
	$email_required = ' required="required"';
} else {
	$email_required = '';
}
// $view_email = '
// 	<input type="text" id="iqr_email_01"'.$email_required.' data-input="email"  />
// 	<span class="bridge">@</span>
// 	<input type="text" id="iqr_email_02"'.$email_required.' data-input="email" />
// 	<span class="nbsp"></span>
// 	<select id="iqr_email_03" data-input="email">
// 		<option value="">직접입력</option>
// 		<option value="naver.com">naver.com</option>
// 		<option value="gmail.com">gmail.com</option>
// 		<option value="nate.com">nate.com</option>
// 		<option value="yahoo.co.kr">yahoo.co.kr</option>
// 		<option value="hanmail.net">hanmail.net</option>
// 		<option value="daum.net">daum.net</option>
// 		<option value="dreamwiz.com">dreamwiz.com</option>
// 		<option value="lycos.co.kr">lycos.co.kr</option>
// 		<option value="empas.com">empas.com</option>
// 		<option value="korea.com">korea.com</option>
// 		<option value="paran.com">paran.com</option>
// 		<option value="freechal.com">freechal.com</option>
// 		<option value="hanmir.com">hanmir.com</option>
// 		<option value="hotmail.com">hotmail.com</option>
// 	</select>
// ';
$view_email = '
	<input type="text" id="email_01"'.$email_required.' data-input="email" onkeyup="view3_email_value(this);"  />
	<span class="bridge">@</span>
	<input type="text" id="email_02"'.$email_required.' data-input="email" onkeyup="view3_email_value(this);" />
	<select id="email_03" data-input="email" onchange="javascript:view3_email(this,this.options[this.selectedIndex].value);">
		<option value="">직접입력</option>
		<option value="naver.com">naver.com</option>
		<option value="gmail.com">gmail.com</option>
		<option value="nate.com">nate.com</option>
		<option value="yahoo.co.kr">yahoo.co.kr</option>
		<option value="hanmail.net">hanmail.net</option>
		<option value="daum.net">daum.net</option>
		<option value="dreamwiz.com">dreamwiz.com</option>
		<option value="lycos.co.kr">lycos.co.kr</option>
		<option value="empas.com">empas.com</option>
		<option value="korea.com">korea.com</option>
		<option value="paran.com">paran.com</option>
		<option value="freechal.com">freechal.com</option>
		<option value="hanmir.com">hanmir.com</option>
		<option value="hotmail.com">hotmail.com</option>
	</select>
';
?>

<!-- board wrapper start -->
<div id="boardWrap">
	<div class="inquiry_wrap">
		<form name="inquiry_write" method="post" action="<?=BOARD?>/index.php?<?=$path_action?>" enctype="multipart/form-data" accept-charset="<?=SET?>" class="inquiry_form">
			<input type="hidden" name="drop" value="drop||privacy_agree||board||pw||skin||url||inquiry_action||x||y" />
			<input type="hidden" name="board" value="<?=$board?>" />
			<input type="hidden" name="sca" value="<?=$view3_sca?>" />
			<input type="hidden" name="inquiry_action" value="ok" />
			<input type="hidden" name="url" value="<?=URL?>" />
			<input type="hidden" name="title_01" value="<?=$h2_title_sub?>" />
			<input type="hidden" name="email" value="" />
			<input type="hidden" name="special_03" value="" />
			<fieldset class="iqr_policy_wrap">
				<legend class="iqr_tit b_ff_h b_c_m" style="display:none">개인정보 수집 및 활용동의</legend>
				<div class="iqr_policy" style="display:none">
                    <ol>
                        <li class="b_fs_l b_ff_m b_lh_m b_c_l">
                        1. 개인정보의 수집 및 이용 목적<br>
                        가맹 관련 문의 확인 및 답변을 위한 연락통지, 처리결과 통보 등을 목적으로 개인정보를 처리합니다.
                        </li>
                        <li class="b_fs_l b_ff_m b_lh_m b_c_l">
                        2. 처리하는 개인정보 항목<br>
                        - 필수항목 : 이름, 연락처 (접속 IP 정보, 쿠키, 서비스 이용 기록, 접속 로그)<br>
                        - 선택항목 : 이메일
                        </li>
                        <li class="b_fs_l b_ff_m b_lh_m b_c_l">
                        3. 개인정보의 처리 및 보유 기간<br>
                        ① 법령에 따른 개인정보 보유.이용기간 또는 정보주체로부터 개인정보를 수집 시에 동의 받은 개인정보 보유, 이용기간 내에서 개인정보를 처리, 보유합니다.<br>
                        ② 개인정보의 보유 기간은 5년입니다.
                        </li>
                    </ol>
				</div>
				<!-- <div class="iqr_check">
					<input type="checkbox" name="inquiry_policy_check" id="inquiryPolicyCheck" />
					<label for="inquiryPolicyCheck" class="b_ff_m b_c_l">위 개인정보 수집 및 활용에 동의합니다.</label>
				</div> -->
				<div class="iqr_check rel">
					<input type="checkbox" name="privacy_agree" id="inquiryPolicyCheck" />
					<label for="inquiryPolicyCheck" class="b_ff_m b_c_l">개인정보취급방침을 읽었으며 이에 동의합니다.</label>
					<a href="#none" class="bindPolicyModalOpen open_policy" data-type="0">전문보기</a>
				</div>
			</fieldset>
			<fieldset class="iqr_info">
				<legend class="iqr_tit rel b_ff_h b_c_m">상담자 정보<small class="iqr_dot b_ff_m b_c_l"><span>동그라미 표시</span>는 필수입력항목입니다.</small></legend>
				<table summary="상담자 정보 입력사항" class="inquiry_table">
					<caption class="indent">상담자 정보 입력사항</caption>
					<colgroup>
						<col width="25%">
						<col width="*">
					</colgroup>
					<tbody>
<?
######################################################################################################################################################
if($view3_sca == 'customer_01') {
?>
						<tr>
							<th scope="row"><label for="iqr_title_01" class="required">제목</label></th>
							<td>
								<input type="text" name="title_01" id="iqr_title_01" required="required" />
							</td>
						</tr>
<?
}
?>
						<tr>
							<th scope="row" class="col1"><label for="iqr_name" class="required">이름</label></th>
							<td class="col2"><input type="text" name="name" id="iqr_name" required="required" /></td>
						</tr>
						<!-- <tr>
							<th scope="row"><label for="iqr_hp" class="required">연락처</label></th>
							<td>
								<input type="text" name="hp" id="iqr_hp" required="required" />
							</td>
						</tr> -->
						<tr>
							<th scope="row"><label for="iqr_hp" class="required">연락처</label></th>
							<td>
								<input type="text" name="hp" id="iqr_hp" required="required" onkeyup="hero_key(this,1);" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="iqr_email_01"<?if($email_required){echo ' class="required"';}?>>이메일</label></th>
							<td class="email_td fs_def">
								<?=$view_email?>
							</td>
						</tr>
<?
if($view3_sca == '1n1_01' || $view3_sca == 'jungbo_01' || $view3_sca == 'changup_01') {
?>
						<!-- <tr>
							<th scope="row"><label for="iqr_special_03_01">창업희망지역</label></th>
							<td>
								<select id="iqr_special_03_01" data-input="special_03">
									<option value="">지역 선택</option>
								</select>
								<span class="bridge"></span>
								<select id="iqr_special_03_02" data-input="special_03">
									<option value="">시 / 군 / 구 선택</option>
								</select>
							</td>
						</tr> -->
						<tr>
							<th scope="row"><label for="iqr_special_03">희망개설지역</label></th>
							<td>
								<input type="text" name="special_03" id="iqr_special_03" />
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="iqr_special_05">임대차 목적물 보유</label></th>
							<td class="fs_def fs_0">
								<input type="radio" name="special_05" id="iqr_special_05_01" class="op0" value="무" checked="checked" />
								<label for="iqr_special_05_01" class="radio_label radio_label2 ml0">없음</label>
								<input type="radio" name="special_05" id="iqr_special_05_02" class="op0" value="유" />
								<label for="iqr_special_05_02" class="radio_label radio_label2">있음</label>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="iqr_special_04">보유시 임대차 목적물 면적</label></th>
							<td>
								<input type="text" name="special_04" id="iqr_special_04" />
								<span class="text">㎡</span>
							</td>
						</tr>
<?
} else if($view3_sca == 'customer_01') {
?>
						<tr>
							<th scope="row"><label for="iqr_special_07">매장</label></th>
							<td>
								<select id="iqr_special_07" name="special_07">
									<option value="">매장선택</option>
									<?
									$map_sql = "select * from ".TABLE_LEFT."map_01 where view3_use = 1 order by view3_order desc";
									$map_res = mysql_query($map_sql);
									while ($map_lst = mysql_fetch_assoc($map_res)) {
									?>
										<option value="<?=$map_lst['view3_idx']?>"><?=$map_lst['view3_title_01']?></option>
									<?
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="iqr_special_03_01">상담유형</label></th>
							<td>
								<input type="radio" name="special_03" id="special_03_01" value="칭찬" checked="checked" />
								<label for="special_03_01" class="radio_tlabel">칭찬</label>
								<span class="nbsp"></span>
								<input type="radio" name="special_03" id="special_03_02" value="불만" />
								<label for="special_03_02" class="radio_tlabel">불만</label>
								<span class="nbsp"></span>
								<input type="radio" name="special_03" id="special_03_03" value="문의" />
								<label for="special_03_03" class="radio_tlabel">문의</label>
								<span class="nbsp"></span>
								<input type="radio" name="special_03" id="special_03_04" value="제안" />
								<label for="special_03_04" class="radio_tlabel">제안</label>
							</td>
						</tr>
<?
}
######################################################################################################################################################
?>
						<tr>
							<th scope="row" class="v_top"><label for="iqr_command_01" class="required">추가 의견</label></th>
							<td>
								<textarea name="command_01" id="iqr_command_01" required="required"></textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<button type="submit" class="b_btn01 bindInquirySubmit" onclick="inquiry(this.form);">신청하기</button>
			</fieldset>
		</form>
    </div>
</div>
<!-- //board wrapper end -->
