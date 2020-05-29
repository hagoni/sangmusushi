<?php
    $geo_sql = "select * from ".TABLE_LEFT."map_01 where view3_use = 1 order by view3_order desc, view3_write_day desc";

    $geo_res = mysql_query($geo_sql);
    $geo_num = mysql_num_rows($geo_res);
    $cnt = 0;
    while ($geo_lst = mysql_fetch_assoc($geo_res)) {
        $geo_arr[$cnt]['view3_idx'] = $geo_lst['view3_idx'];
        $geo_arr[$cnt]['lat'] = $geo_lst['view3_addr_y'];
        $geo_arr[$cnt]['lon'] = $geo_lst['view3_addr_x'];
        $cnt++;
    }
    json_encode($geo_arr);
 ?>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?autoload=false&libraries=services&appkey=<?=$settings_data['kakao_api_key'];?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        daum.maps.load(function() {
            // HTML5의 geolocation으로 사용할 수 있는지 확인합니다
            if (navigator.geolocation) {
                // GeoLocation을 이용해서 접속 위치를 얻어옵니다
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude, // 위도
                        lon = position.coords.longitude; // 경도

                    var mapLocation = <?=json_encode($geo_arr)?>;
                    var temp = 0;
                    var mapIndex = "";
            		var startPosition = new kakao.maps.LatLng(lat, lon);

                    for (var i = 0; i < mapLocation.length; i++) {
                        var endPosition = new kakao.maps.LatLng(mapLocation[i]['lat'], mapLocation[i]['lon']);
                        var distancePoly = new kakao.maps.Polyline({
                            path: [startPosition, endPosition]
                        });
                        var distance = Math.round((distancePoly.getLength()));

                        if (i == 0) {
                            temp = distance;
                            mapIndex = mapLocation[i]['view3_idx'];
                        } else {
                            if (temp > distance) {
                                temp = distance;
                                mapIndex = mapLocation[i]['view3_idx'];
                            }
                        }
                    }

                    $.post('<?=$root?>/resource/map_01.php',{idx:mapIndex},function(res){

                        var data = JSON.parse(res);

                        $(document).find('.geo_cont').css('display','block');
                        $(document).find('.geo_tlt span').html(data['title']);
                        $(document).find('.geo_con').html(data['title'] + ' 이 귀하와 가장 가까운 곳에 위치하고 있습니다.');
                        $(document).find('.geo_link').attr('href','<?=BOARD?>/index.php?board=map_01&type=view&skin=map_00&modal=1&idx='+mapIndex);
                        $(document).find('.geo_link').attr('data-notice-idx',mapIndex);
                    });
                },function(error){
                    console.log(error);
                });
            }
        });
    });
</script>
