<?
// $nowTime = strtotime('2020-03-19 23:30:01');
$nowTime = time();
date_default_timezone_set("Asia/Seoul");
$salesTotalAmount = 1662006;
$stdVal = [];
$stdVal['acc_delivery'] = 403200;//누적 배달량
$stdVal['acc_takeaway'] = 427806;//누적 포장
$stdVal['acc_visitor'] = 1662006;//누적 매장 방문자
$stdVal['acc_sushi'] = 2493012;//누적 초밥 판매량(메뉴)
$stdVal['start_date'] = '2019-01-01';//누적 기준 카운트 시작일자
$stdVal['avg_delivery'] = round(403200/365);//하루 평균 배달량
$stdVal['avg_takeaway'] = round(427806/365);//하루 평균 포장
$stdVal['avg_visitor'] = round(1662006/365);//하루 평균 매장 방문자
$stdVal['avg_sushi'] = round(2493012/365);//하루 평균 초밥 판매량(메뉴)
$stdVal['salse_hour'] = 12;//하루 판매시간
$stdVal['shop_open_time'] = '11:30:00';//하루 판매 시작시간
$stdVal['shop_close_time'] = '23:00:00';//하루 판매 종료시간, 익일 3시 '03:00:00'

//영업시간 진행 퍼센트
$time1 = strtotime(date('Y-m-d ').$stdVal['shop_open_time']);
$time2 = strtotime(date('Y-m-d ').$stdVal['shop_close_time']);
if($time1>$time2){//익일 처리
    if($nowTime <= $time2){//종료시간 전이면 오픈시간 1일 빼기
        $time1 = strtotime('-1 day',$time1);
    }else{//종료시간 이후면 있으면 종료시간 1일 더하기
        $time2 = strtotime('+1 day',$time2);
    }
}

//누적 일자 계산
$date1 = new DateTime($stdVal['start_date']);//시작날짜
$date2 = new DateTime(date('Y-m-d', $time1));//현재날짜
$interval = $date1->diff($date2);
$accDay = (int)$interval->format('%a');//누적일

$totalSec = $time2-$time1;
$onSalesLive = false;
$salseTimePercent = 0;
if($time1>$nowTime){
    //오픈 전(영업종료)
}else if($time1 <= $nowTime && $time2 >= $nowTime){
    //영업중
    $onSalesLive = true;
    $salseTimePercent = (($nowTime-$time1)/$totalSec*100);
}else if($time2<$nowTime){
    //영업종료(익일 종료는 첫 번째 조건에서 걸림)
    $salseTimePercent = 100;
}
if($salseTimePercent>100)$salseTimePercent = 100;

$result = [];
//현재 판매량 = 누적A(~기준일) + 누적B(기준일~) + (당일 판매량 * 영업진행률%)
$result['onSalesLive'] = $onSalesLive;//영업중 상태
$result['cnt_delivery'] = $stdVal['acc_delivery']+($accDay*$stdVal['avg_delivery'])+ceil($stdVal['avg_delivery']*$salseTimePercent/100);//실시간 총 누적 배달량
$result['cnt_takeaway'] = $stdVal['acc_takeaway']+($accDay*$stdVal['avg_takeaway'])+ceil($stdVal['avg_takeaway']*$salseTimePercent/100);//실시간 총 누적 포장
$result['cnt_visitor'] = $stdVal['acc_visitor']+($accDay*$stdVal['avg_visitor'])+ceil($stdVal['avg_visitor']*$salseTimePercent/100);//실시간 총 누적 매장 방문자
$result['cnt_sushi'] = $stdVal['acc_sushi']+($accDay*$stdVal['avg_sushi'])+ceil($stdVal['avg_sushi']*$salseTimePercent/100);//실시간 총 누적 초밥 판매량(메뉴)

// echo '['.$stdVal['acc_sushi'].'+('.($accDay*$stdVal['avg_sushi']).')+ceil('.($stdVal['avg_sushi']*$salseTimePercent/100).')]'.PHP_EOL;
// var_dump(ceil($stdVal['avg_sushi']*$salseTimePercent/100));
if(!defined('ROOT_INC')){
    echo $_GET['callback'].'('.json_encode($result).')';
}
?>