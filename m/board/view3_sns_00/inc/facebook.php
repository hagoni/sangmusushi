<div class="fb_wrap">

<?
if($linkbar_show == true) {
?>
    <div class="linkbar m_t50">
        <a href="https://facebook.com/<?=$fbPageId?>/" target="_blank" title="<?=$sitename?> facebook 바로가기"><img src="<?=$skinPath?>/img/linkbar_fb.jpg" alt="<?=$sitename?> facebook 바로가기"></a>
    </div>
<?
}
?>
    <div class="fb_header">
        <div class="fbCover col1 cols"><img src="<?=$skinPath?>/img/pixel1x1.png" alt=""></div>
        <div class="col2 cols">
            <p class="fbAbout row1 b_fs_m b_c_l ellipsis"></p>
            <p class="fbName row2 b_ff_h b_c_m"></p>
        </div>
        <div class="col3">
            <div class="fb-like" data-href="https://www.facebook.com/<?=$fbPageId?>/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
        </div>
    </div>

    <ul class="fbContainer fb_list"></ul>

    <div class="load_more">
        <a href="#none" class="fbMore spinner">
            <span class="load_link_tt">더보기</span>
            <span class="load_spinner"><img src="<?=$skinPath?>/img/spinner02.gif" alt=""></span>
        </a>
    </div>

<?
$fbContainerId = $_REQUEST['fbContainerId'] ? $_REQUEST['fbContainerId'] : '#boardWrap';
?>
<script src="<?=$skinPath?>/js/FP.js"></script>
<script>
(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/ko_KR/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));

(function($) {
    window.fbAsyncInit = function() {
        var wrapper = $('<?=$fbContainerId?>');
        new FP($('.fbContainer', wrapper), {
            requestUrl: '<?=$skinPath?>/resource/fb_page_feed.php',
            pageId: '<?=$fbPageId?>',
			wrapper: wrapper,
            limit: 10
        });
    };
}(jQuery));
</script>

</div>