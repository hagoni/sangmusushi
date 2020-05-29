<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
if($view3_sca == 'all') {
?>
<link rel="stylesheet" href="<?=$pc?>/plug_in/mcustomscrollbar/jquery.mCustomScrollbar.css">
<script>
var placeOptions = {board: CONST_BOARD, sca: '<?=$view3_sca?>', skin: '<?=$skin?>', search: '<?=$view3_search?>', select: '<?=$view3_select?>', geolocation: true};
</script>
<script src="//maps.googleapis.com/maps/api/js?language=ko&region=kr&libraries=geometry&sensor=true<?if($settings_data['google_api_key']){echo '&key='.$settings_data['google_api_key'];}?>"></script>
<script src="<?=$pc?>/plug_in/mcustomscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=$skin_path?>/js/Geomap.js?<?=$time?>"></script>

<div class="place_find_container rel">
    <div id="placeFindWrap" class="place_find_wrap">
		<div class="inner">
			<div class="clearfix">
				<div class="cols select select_city f_left">
					<button type="button" id="local1Button">광역시/도</button>
					<div id="local1ListWrap" class="local_list_wrap">
						<ul id="local1" class="local_select">
							<li><a href="#none">전체</a></li>
							<li><a href="#none" data-value="서울">서울</a></li>
							<li><a href="#none" data-value="부산">부산</a></li>
							<li><a href="#none" data-value="대구">대구</a></li>
							<li><a href="#none" data-value="인천">인천</a></li>
							<li><a href="#none" data-value="광주">광주</a></li>
							<li><a href="#none" data-value="대전">대전</a></li>
							<li><a href="#none" data-value="울산">울산</a></li>
							<li><a href="#none" data-value="세종">세종</a></li>
							<li><a href="#none" data-value="경기">경기</a></li>
							<li><a href="#none" data-value="강원">강원</a></li>
							<li><a href="#none" data-value="충북">충북</a></li>
							<li><a href="#none" data-value="충남">충남</a></li>
							<li><a href="#none" data-value="전북">전북</a></li>
							<li><a href="#none" data-value="전남">전남</a></li>
							<li><a href="#none" data-value="경북">경북</a></li>
							<li><a href="#none" data-value="경남">경남</a></li>
							<li><a href="#none" data-value="제주">제주</a></li>
						</ul>
					</div>
				</div>
				<div class="cols select f_left">
					<button type="button" id="local2Button">시/군/구</button>
					<div id="local2ListWrap" class="local_list_wrap">
						<ul id="local2" class="local_select">
						</ul>
					</div>
				</div>
			</div>
			<div class="cols input">
				<form class="placefindbyname" onsubmit="return false;">
					<fieldset>
						<legend class="indent">매장 검색</legend>
						<label for="placeName">매장명 또는 주소를 입력해주세요.</label>
						<input type="text" name="placeName" id="placeName" class="place_name">
						<input type="submit" id="btnFindSubmit" class="place_btn">
					</fieldset>
				</form>
			</div>
		</div>
    </div>
    <button type="button" id="geolocator" class="geo_locator"></button>
    <div id="placeLoadMap"></div>
</div>
<?
}
?>

<!-- store list start -->
<div id="storeListWrap" class="store_list_wrap">
<?
if($total_data > 0) {
?>
	<ul class="store_ul inner">
<?
    $list_page = 10;
    $page_per_list = 5;
    $start = ($view3_page - 1) * $list_page;
    page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
    $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
    $out_sql = mysql_query($sql);
    while($list = mysql_fetch_assoc($out_sql)) {
        $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
        if($list['view3_addr_road']) {
    		$addr = $list['view3_addr_road']." ".$list['view3_addr_detail'];
    	} else {
    		$addr = $list['view3_addr_number']." ".$list['view3_addr_detail'];
    	}
?>
		<li class="store_li">
			<p class="store_name"><?=$list['view3_title_01']?><?if($list['view3_special_01'] == 2){?><span class="new"><img src="<?=$skin_path?>/img/new.png" alt="" class="w100"></span><?}?></p>
			<p class="store_addr ellipsis"><?=$addr?></p>
			<p class="store_tel"><?=$list['view3_special_04']?></p>
			<a href="#none" class="anchor-location-pop store_info" data-idx="<?=$list['view3_idx']?>"><img src="<?=$skin_path?>/img/store_info.png" alt="information" class="w100"></a>
			<a href="#none" class="anchor-location-nav store_kmap" data-title="<?=$list['view3_title_01']?>" data-x="<?=$list['view3_addr_x']?>" data-y="<?=$list['view3_addr_y']?>"><img src="<?=$skin_path?>/img/k_map.png" alt="카카오맵" class="w100"></a>
		</li>
<?
    }
?>
	</ul>

    <!-- paging start -->
	<div class="paging fs_def">
		<?=$out_page?>
	</div>
	<!-- //paging end -->

<?
} else {
    $text = $view3_search ? '검색 결과가 없습니다.' : '게시물이 없습니다.';
	echo '<p class="nodata">'.$text.'</p>'.PHP_EOL;
}
?>

</div>
<!-- //store list end -->

<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$settings_data['kakao_api_m_key'];?>&libraries=services"></script>
<script src="<?=$skin_path?>/js/KakaoMap.js"></script>
<?
if($_POST['modal'] && $_POST['idx']) {
    $idx = $_POST['idx'];
	$top_list_query = $main_sql." and view3_idx = '$idx'";
	$top_result = mysql_query($top_list_query);
	$list = mysql_fetch_assoc($top_result);
    if($list['view3_addr_road']) {
        $addr = $list['view3_addr_road']." ".$list['view3_addr_detail'];
    } else {
        $addr = $list['view3_addr_number']." ".$list['view3_addr_detail'];
    }
?>
<!-- 매장상세 팝업 start -->
<div id="locationPopParent">
	<div id="locationPopContainer" class="location_view abs">
		<p class="loc_pop_title ellipsis"><?=$list['view3_title_01']?><?if($list['view3_special_01'] == 2){?><span class="new"><img src="<?=$skin_path?>/img/new.png" alt="" class="w100"></span><?}?></p>
		<button type="button" id="locationPopX" class="view_close">닫기</button>
		<ul class="location_info">
			<li>
				<dl class="over_h">
					<dt class="f_left">매장주소</dt>
					<dd class="f_left"><?=$addr?></dd>
				</dl>
			</li>
<?
    if($list['view3_special_04']) {
?>
			<li>
				<dl class="over_h">
					<dt class="f_left">전화번호</dt>
					<dd class="f_left"><?=$list['view3_special_04']?></dd>
				</dl>
			</li>
<?
    }
    if($list['view3_special_02']) {
?>
			<li>
				<dl class="over_h">
					<dt class="f_left">영업시간</dt>
					<dd class="f_left"><?=$list['view3_special_02']?></dd>
				</dl>
			</li>
<?
	}
?>
		</ul>
		<div id="viewRoughMap" class="view_map_area"></div>
		<ul class="view_links over_h">
			<li><a href="#none" class="anchor-location-copy" data-clipboard-text="<?=$addr?>"><img src="<?=$skin_path?>/img/link_ico01.png" alt="" class="view_link01">&nbsp;&nbsp;&nbsp;주소 복사</a></li>
			<li><a href="#none" class="anchor-location-nav" data-title="<?=$list['view3_title_01']?>" data-x="<?=$list['view3_addr_x']?>" data-y="<?=$list['view3_addr_y']?>"><img src="<?=$skin_path?>/img/loc_link02.jpg" alt="" class="view_link02">&nbsp;&nbsp;&nbsp;카카오내비</a></li>
		</ul>
	</div>
	<!-- //매장상세 팝업 end -->

<script>
$(document).ready(function() {
	<?
	$markerImgPath = '/design/other/marker.png';
	$markerImgSize = getImagesize(ROOT_INC.$markerImgPath);
	?>

	new KakaoMap('viewRoughMap', {
		geocode: {lat: '<?=$list['view3_addr_y']?>', lng: '<?=$list['view3_addr_x']?>'},
		scrollwheel: false,
		marker: {
			src: '<?=$pc.$markerImgPath?>',
			offset: {x: <?=$markerImgSize[0] / 2?>, y: <?=$markerImgSize[1]?>},
			size: {x: <?=$markerImgSize[0]?>, y: <?=$markerImgSize[1]?>}
		}
	});
});
</script>

</div>
<!-- //locationPop end -->

<?
}
?>

<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script>
/*!
 * clipboard.js v2.0.0
 * https://zenorocha.github.io/clipboard.js
 *
 * Licensed MIT © Zeno Rocha
 */
!function(t,e){"object"==typeof exports&&"object"==typeof module?module.exports=e():"function"==typeof define&&define.amd?define([],e):"object"==typeof exports?exports.ClipboardJS=e():t.ClipboardJS=e()}(this,function(){return function(t){function e(o){if(n[o])return n[o].exports;var r=n[o]={i:o,l:!1,exports:{}};return t[o].call(r.exports,r,r.exports,e),r.l=!0,r.exports}var n={};return e.m=t,e.c=n,e.i=function(t){return t},e.d=function(t,n,o){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:o})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=3)}([function(t,e,n){var o,r,i;!function(a,c){r=[t,n(7)],o=c,void 0!==(i="function"==typeof o?o.apply(e,r):o)&&(t.exports=i)}(0,function(t,e){"use strict";function n(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}var o=function(t){return t&&t.__esModule?t:{default:t}}(e),r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},i=function(){function t(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}return function(e,n,o){return n&&t(e.prototype,n),o&&t(e,o),e}}(),a=function(){function t(e){n(this,t),this.resolveOptions(e),this.initSelection()}return i(t,[{key:"resolveOptions",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};this.action=t.action,this.container=t.container,this.emitter=t.emitter,this.target=t.target,this.text=t.text,this.trigger=t.trigger,this.selectedText=""}},{key:"initSelection",value:function(){this.text?this.selectFake():this.target&&this.selectTarget()}},{key:"selectFake",value:function(){var t=this,e="rtl"==document.documentElement.getAttribute("dir");this.removeFake(),this.fakeHandlerCallback=function(){return t.removeFake()},this.fakeHandler=this.container.addEventListener("click",this.fakeHandlerCallback)||!0,this.fakeElem=document.createElement("textarea"),this.fakeElem.style.fontSize="12pt",this.fakeElem.style.border="0",this.fakeElem.style.padding="0",this.fakeElem.style.margin="0",this.fakeElem.style.position="absolute",this.fakeElem.style[e?"right":"left"]="-9999px";var n=window.pageYOffset||document.documentElement.scrollTop;this.fakeElem.style.top=n+"px",this.fakeElem.setAttribute("readonly",""),this.fakeElem.value=this.text,this.container.appendChild(this.fakeElem),this.selectedText=(0,o.default)(this.fakeElem),this.copyText()}},{key:"removeFake",value:function(){this.fakeHandler&&(this.container.removeEventListener("click",this.fakeHandlerCallback),this.fakeHandler=null,this.fakeHandlerCallback=null),this.fakeElem&&(this.container.removeChild(this.fakeElem),this.fakeElem=null)}},{key:"selectTarget",value:function(){this.selectedText=(0,o.default)(this.target),this.copyText()}},{key:"copyText",value:function(){var t=void 0;try{t=document.execCommand(this.action)}catch(e){t=!1}this.handleResult(t)}},{key:"handleResult",value:function(t){this.emitter.emit(t?"success":"error",{action:this.action,text:this.selectedText,trigger:this.trigger,clearSelection:this.clearSelection.bind(this)})}},{key:"clearSelection",value:function(){this.trigger&&this.trigger.focus(),window.getSelection().removeAllRanges()}},{key:"destroy",value:function(){this.removeFake()}},{key:"action",set:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"copy";if(this._action=t,"copy"!==this._action&&"cut"!==this._action)throw new Error('Invalid "action" value, use either "copy" or "cut"')},get:function(){return this._action}},{key:"target",set:function(t){if(void 0!==t){if(!t||"object"!==(void 0===t?"undefined":r(t))||1!==t.nodeType)throw new Error('Invalid "target" value, use a valid Element');if("copy"===this.action&&t.hasAttribute("disabled"))throw new Error('Invalid "target" attribute. Please use "readonly" instead of "disabled" attribute');if("cut"===this.action&&(t.hasAttribute("readonly")||t.hasAttribute("disabled")))throw new Error('Invalid "target" attribute. You can\'t cut text from elements with "readonly" or "disabled" attributes');this._target=t}},get:function(){return this._target}}]),t}();t.exports=a})},function(t,e,n){function o(t,e,n){if(!t&&!e&&!n)throw new Error("Missing required arguments");if(!c.string(e))throw new TypeError("Second argument must be a String");if(!c.fn(n))throw new TypeError("Third argument must be a Function");if(c.node(t))return r(t,e,n);if(c.nodeList(t))return i(t,e,n);if(c.string(t))return a(t,e,n);throw new TypeError("First argument must be a String, HTMLElement, HTMLCollection, or NodeList")}function r(t,e,n){return t.addEventListener(e,n),{destroy:function(){t.removeEventListener(e,n)}}}function i(t,e,n){return Array.prototype.forEach.call(t,function(t){t.addEventListener(e,n)}),{destroy:function(){Array.prototype.forEach.call(t,function(t){t.removeEventListener(e,n)})}}}function a(t,e,n){return u(document.body,t,e,n)}var c=n(6),u=n(5);t.exports=o},function(t,e){function n(){}n.prototype={on:function(t,e,n){var o=this.e||(this.e={});return(o[t]||(o[t]=[])).push({fn:e,ctx:n}),this},once:function(t,e,n){function o(){r.off(t,o),e.apply(n,arguments)}var r=this;return o._=e,this.on(t,o,n)},emit:function(t){var e=[].slice.call(arguments,1),n=((this.e||(this.e={}))[t]||[]).slice(),o=0,r=n.length;for(o;o<r;o++)n[o].fn.apply(n[o].ctx,e);return this},off:function(t,e){var n=this.e||(this.e={}),o=n[t],r=[];if(o&&e)for(var i=0,a=o.length;i<a;i++)o[i].fn!==e&&o[i].fn._!==e&&r.push(o[i]);return r.length?n[t]=r:delete n[t],this}},t.exports=n},function(t,e,n){var o,r,i;!function(a,c){r=[t,n(0),n(2),n(1)],o=c,void 0!==(i="function"==typeof o?o.apply(e,r):o)&&(t.exports=i)}(0,function(t,e,n,o){"use strict";function r(t){return t&&t.__esModule?t:{default:t}}function i(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function a(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function c(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}function u(t,e){var n="data-clipboard-"+t;if(e.hasAttribute(n))return e.getAttribute(n)}var l=r(e),s=r(n),f=r(o),d="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},h=function(){function t(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}return function(e,n,o){return n&&t(e.prototype,n),o&&t(e,o),e}}(),p=function(t){function e(t,n){i(this,e);var o=a(this,(e.__proto__||Object.getPrototypeOf(e)).call(this));return o.resolveOptions(n),o.listenClick(t),o}return c(e,t),h(e,[{key:"resolveOptions",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};this.action="function"==typeof t.action?t.action:this.defaultAction,this.target="function"==typeof t.target?t.target:this.defaultTarget,this.text="function"==typeof t.text?t.text:this.defaultText,this.container="object"===d(t.container)?t.container:document.body}},{key:"listenClick",value:function(t){var e=this;this.listener=(0,f.default)(t,"click",function(t){return e.onClick(t)})}},{key:"onClick",value:function(t){var e=t.delegateTarget||t.currentTarget;this.clipboardAction&&(this.clipboardAction=null),this.clipboardAction=new l.default({action:this.action(e),target:this.target(e),text:this.text(e),container:this.container,trigger:e,emitter:this})}},{key:"defaultAction",value:function(t){return u("action",t)}},{key:"defaultTarget",value:function(t){var e=u("target",t);if(e)return document.querySelector(e)}},{key:"defaultText",value:function(t){return u("text",t)}},{key:"destroy",value:function(){this.listener.destroy(),this.clipboardAction&&(this.clipboardAction.destroy(),this.clipboardAction=null)}}],[{key:"isSupported",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:["copy","cut"],e="string"==typeof t?[t]:t,n=!!document.queryCommandSupported;return e.forEach(function(t){n=n&&!!document.queryCommandSupported(t)}),n}}]),e}(s.default);t.exports=p})},function(t,e){function n(t,e){for(;t&&t.nodeType!==o;){if("function"==typeof t.matches&&t.matches(e))return t;t=t.parentNode}}var o=9;if("undefined"!=typeof Element&&!Element.prototype.matches){var r=Element.prototype;r.matches=r.matchesSelector||r.mozMatchesSelector||r.msMatchesSelector||r.oMatchesSelector||r.webkitMatchesSelector}t.exports=n},function(t,e,n){function o(t,e,n,o,r){var a=i.apply(this,arguments);return t.addEventListener(n,a,r),{destroy:function(){t.removeEventListener(n,a,r)}}}function r(t,e,n,r,i){return"function"==typeof t.addEventListener?o.apply(null,arguments):"function"==typeof n?o.bind(null,document).apply(null,arguments):("string"==typeof t&&(t=document.querySelectorAll(t)),Array.prototype.map.call(t,function(t){return o(t,e,n,r,i)}))}function i(t,e,n,o){return function(n){n.delegateTarget=a(n.target,e),n.delegateTarget&&o.call(t,n)}}var a=n(4);t.exports=r},function(t,e){e.node=function(t){return void 0!==t&&t instanceof HTMLElement&&1===t.nodeType},e.nodeList=function(t){var n=Object.prototype.toString.call(t);return void 0!==t&&("[object NodeList]"===n||"[object HTMLCollection]"===n)&&"length"in t&&(0===t.length||e.node(t[0]))},e.string=function(t){return"string"==typeof t||t instanceof String},e.fn=function(t){return"[object Function]"===Object.prototype.toString.call(t)}},function(t,e){function n(t){var e;if("SELECT"===t.nodeName)t.focus(),e=t.value;else if("INPUT"===t.nodeName||"TEXTAREA"===t.nodeName){var n=t.hasAttribute("readonly");n||t.setAttribute("readonly",""),t.select(),t.setSelectionRange(0,t.value.length),n||t.removeAttribute("readonly"),e=t.value}else{t.hasAttribute("contenteditable")&&t.focus();var o=window.getSelection(),r=document.createRange();r.selectNodeContents(t),o.removeAllRanges(),o.addRange(r),e=o.toString()}return e}t.exports=n}])});


(function($) {
	$(document).ready(function() {
		(function() {
            function modalOpen(e) {
                if(changing === false) {
                    $.post(location.href, {modal: true, idx: $(this).data('idx')}, function(response) {
                        $topElement.append('<div id="'+ _containerBlock.replace('#', '') +'"></div>');
                        $containerBlock = $(_containerBlock);
                        var html = $(response).filter(_parent).length > 0 ? $(response).filter(_parent).html() : $(response).find(_parent).html();
                        $topElement.append(html);
                        $container = $(_container);
                        fixModalCss();
                        $container.css({display: 'block', opacity: 0, position: modalPosition, top: modalTop + 50, marginTop: 0});
                        $container.animate({opacity: 1, top: modalTop}, 500, function() {
                            win.on('resize', resize);
                            changing = false;
                            open = true;
                        });
                    });
                    changing = true;
                }
                e.preventDefault();
            }

            function modalX() {
                $container.animate({opacity: 0, top: modalTop - 50}, 200, function() {
                    $containerBlock.remove();
                    $container.remove();
                    win.off('resize', resize);
                    open = false;
                });
            }

            function fixModalCss() {
                if(typeof containerH === 'undefined') containerH = parseInt($container.css('height'), 10);
                if(win.innerHeight() > containerH) {
                    modalPosition = 'fixed';
                    modalTop = (win.innerHeight() / 2) - (containerH / 2);
                } else {
                    modalPosition = 'absolute';
                    modalTop = win.scrollTop() + 100;
                }
            }

            function resize() {
                clearTimeout(resizeTimer);
                if(typeof $container === 'object') {
                    resizeTimer = setTimeout(function() {
                        fixModalCss();
                        $container.css({position: modalPosition, top: modalTop});
                    }, 100);
                }
            };

            var $topElement = $('body'),
                _containerBlock = '#locationPopBlock',
                $containerBlock,
                _container = '#locationPopContainer',
                $container,
                _parent = '#locationPopParent',
                _anchor = '.anchor-location-pop',
                _closer = '#locationPopX',
                containerH,
                modalPosition,
                modalTop,
                resizeTimer = null,
                changing = false,
                open = false;

            $topElement.on('click', _anchor, modalOpen);
            $topElement.on('click', _closer, modalX);
			$topElement.on('click', function(e) {
				if(open === true && $(e.target).is(_container + ' *') === false) modalX();
			});

            var idx = '<?=$_REQUEST['idx']?>';
            if(idx && $(_anchor).filter('[data-idx="'+ idx +'"]').length > 0) {
                $(_anchor).filter('[data-idx="'+ idx +'"]').first().trigger('click');
            }
        }());

		(function() {
			var clipboard = new ClipboardJS('.anchor-location-copy');
			clipboard.on('success', function(e) {
			    alert('복사 되었습니다.');
			    e.clearSelection();
			});

			Kakao.init('<?=$settings_data['kakao_api_key'];?>');
			$('body').on('click', '.anchor-location-nav', function(e) {
				if($(this).data('x')) {
					Kakao.Navi.share({
						name: $(this).data('title'),
						x: $(this).data('x'),
						y: $(this).data('y'),
						coordType: 'wgs84'
					});
				} else {
					alert('주소 정보가 정확하지 않습니다.');
				}
			});
		}());
	});
}(jQuery));
</script>