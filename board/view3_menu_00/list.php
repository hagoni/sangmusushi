<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- board wrapper start -->
<div id="boardWrap" >
<?
if($total_data > 0) {
?>
	<div id="menuInfoContainer" class="menu_info"<?if(isset($_REQUEST['idx']) == false){echo ' style="display:none"';}?>>
<?
	if($_REQUEST['idx']) {
		$view3_idx = $_REQUEST['idx'];
		$top_sql = $main_sql." and view3_idx='".$view3_idx."'".$view_order;
		$out_top_sql = mysql_query($top_sql);
		$top_list = mysql_fetch_assoc($out_top_sql);
		view3_prev_next($view3_table,$view3_idx);
		$top_option = view3_option(array($top_list['view3_file'],$top_list['view3_file_old'],$board),$top_list['view3_write_day'],$top_list['view3_notice'],$top_list['view3_main'],array($top_list["view3_code"],$top_list['view3_name']),array($top_list['view3_open'],$top_list['view3_close']));
		$next_command_01 = view3_html($top_list['view3_command_01']);
?>

			<div class="slider-container">
				<ul class="slider-wrapper">
					<li class="slider-items" data-idx="<?=$top_list['view3_idx'];?>">
						<!-- menu_best_wrap start -->
						<div class="menu_best_wrap">
							<div class="slider-container nested">
								<ul class="slider-wrapper nested">
<?
									$fileList = explode('||',$top_list['view3_file']);
									$fileCnt = 0;
									foreach($fileList as $idx => $res){
										if($idx<2)continue;
										$fileUrl = $pc.'/upload/'.$board.$res;
?>
									<li class="slider-items nested"><img src="<?=$fileUrl?>" alt="" class="w100<?if($fileCnt==0){echo ' first';}?>" /></li>
<?
										$fileCnt++;
									}
?>
								</ul>
							</div>
							 <div class="mb_paging_area">
								<ul class="mb_paging">
<?
									for($i=1;$i<=$fileCnt;$i++){
?>
									<li <?=$i==1?'class="on"':'';?>><a href="#none"><?=$i;?></a></li>
<?
									}
?>
								</ul>
							</div>
							<div class="mb_txt_wrap">
								<p class="mb_tit"><?=$top_list['view3_title_01'];?><? if($top_list['view3_check_01']=='1'){ ?><span class="icon_box">Best</span><? } ?></p>
								<!--<p class="mb_price"><?=$top_list['view3_title_02'];?></p>-->
								<p class="mb_txt">
									<?=nl2br($top_list['view3_command_01']);?>
								</p>
							</div>
<?
							if($fileList[0]!="" && $top_list['view3_link']!=''){
								$fileUrl = $pc.'/upload/'.$board.$fileList[0];
?>
							<div class="mb_video_wrap">
								<a href="#none" class="bindMovieModalOpen" data-vendor="<?=$top_list['view3_video'];?>" data-id="<?=$top_list['view3_link'];?>">
									<img src="<?=$fileUrl;?>" alt="메뉴소개 동영상" class="w100"/>
								</a>
							</div>
<?
								}
?>
						</div>
						<!--// menu_best_wrap end -->
<?
					$snsQuery = sprintf("SELECT * FROM `%s` WHERE `view3_special_01`='%s' AND `view3_special_02`='%s';", TABLE_LEFT.'multiple_sns', mysql_real_escape_string($board) ,$top_list['view3_idx']);
					$snsResult = mysql_query($snsQuery);
					if($snsResult && mysql_num_rows($snsResult)>0){
						$cleanSnsData = Array();
						$i = 0;
						while($snsData = mysql_fetch_assoc($snsResult)){
							$fileRES = '/upload/multiple_sns'.$snsData['view3_file'];
							if(is_file(ROOT_INC.$fileRES)){
								//이미지만 나오게 하였음
								$cleanSnsData[$i]['image'] = $pc.$fileRES;
								$cleanSnsData[$i]['title'] = $snsData['view3_title_01'];
								$cleanSnsData[$i]['desc'] = $snsData['view3_command_01'];
								$cleanSnsData[$i]['link'] = $snsData['view3_link'];
								$i++;
							}
						}
						if(count($cleanSnsData)>0){
?>
						<!-- review_list start -->
						<div class="review_list">
							<p class="review_tit">블로그 반응</p>
							<div class="review_con_wrap">
								<div class="slider-container nested">
									<ul class="slider-wrapper nested">
<?
							foreach($cleanSnsData as $data){
?>
										<li class="slider-items nested">
											<a href="<?=$data['link'];?>" target="_blank" class="bindSnsModalOpen review_a" data-type="iframe">
												<p class="review_img"><img src="<?=$data['image']?>" alt="" /></p>
												<div class="review_txt_wrap">
													<p class="review_txt p_t15"><?=$data['title'];?></p>
													<p class="review_txt"><?=$data['desc'];?></p>
												</div>
											</a>
										</li>
<?
							}
?>
									</ul>
								</div>
								<button type="button" class="slide_btns btn_prev">이전</button>
								<button type="button" class="slide_btns btn_next">다음</button>
							</div>
						</div>
						<!--// review_list end -->
<?
						}
					}
?>
					</li>
				</ul>
			</div>
			<button type="button" id="menuInfoPrev" class="slider-btns slider-prev" data-idx="<?=$temp_prev?>">이전</button>
			<button type="button" id="menuInfoNext" class="slider-btns slider-next" data-idx="<?=$temp_next?>">다음</button>
			<button type="button" id="menuInfoX" class="menu_close">닫기</button>
<?
	}
?>
	</div>
	<ul class="grid_list">
<?
	$list_page = 99;
	$page_per_list = 10;
	$start = ($view3_page - 1) * $list_page;
	page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
	$sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
	$out_sql = mysql_query($sql);
	$i = 1;
	while($list = mysql_fetch_assoc($out_sql)) {
		$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
?>
		<li<?if($i % 3 == 0){echo ' class="last_col"';}?> data-idx="<?=$list['view3_idx']?>">
			<a href="#none">
				<div class="grid_img_area">
					<div class="grid_hover_wrap">
						<span class="grid_hover_ico"></span>
					</div>
					<?=$option['user_list']?>
					<ul class="grid_ico">
<?
		$special_01_array = explode("||", $list['view3_special_01']);
		if(in_array("1", $special_01_array)) {
?>
							<li>
								<img src="<?=BOARD.'/'.$view3_skin.'/img/circle_box01.png'?>" alt="" class="w100" />
								<span>NEW</span>
							</li>
<?
		}
		if(in_array("2", $special_01_array)) {
?>
							<li>
								<img src="<?=BOARD.'/'.$view3_skin.'/img/circle_box02.png'?>" alt="" class="w100" />
								<span>BEST</span>
							</li>
<?
		}
?>
					</ul>
				</div>
				<p class="grid_txt_area b_fs_l b_c_m ellipsis"><?=$list['view3_title_01']?></p>
			</a>
		</li>
<?
		$i++;
	}
?>

	</ul>

	<!-- paging start -->
	<div class="paging fs_def">
		<?=$out_page?>
	</div>
	<!-- //paging end -->

<script src="<?=BOARD.'/'.$view3_skin?>/js/ResponsiveMenu.js"></script>
<script src="<?=BOARD.'/'.$view3_skin?>/js/SnsModal.js"></script>

<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->