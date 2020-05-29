<?

// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/sangmusushi/?__a=1");

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);
var_dump($output);exit;
exit;
error_reporting(0);

function IGSetToken($id,$pw){
	GLOBAL $curlHandler, $acceptLanguage, $userAgent, $cookieFile, $logFp1;
	curl_setopt($curlHandler, CURLOPT_HTTPHEADER, Array(
		'accept-language: '.$acceptLanguage,
		'user-agent: '.$userAgent
	));
	curl_setopt($curlHandler, CURLOPT_URL, 'https://www.instagram.com/');
	curl_setopt($curlHandler, CURLOPT_COOKIEJAR, $cookieFile);
	curl_setopt($curlHandler, CURLOPT_COOKIEFILE, $cookieFile);
	curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlHandler, CURLOPT_VERBOSE, 1);
	curl_setopt($curlHandler, CURLOPT_STDERR, $logFp1);
	$httpResult = curl_exec($curlHandler);

	#ParseData
	$parse = explode('window._sharedData = ',$httpResult);
	$parse = explode(';</script>',$parse[1]);
	$parse = json_decode($parse[0]);

	curl_setopt($curlHandler, CURLOPT_HTTPHEADER, Array(
		'accept-language: '.$acceptLanguage,
		'user-agent: '.$userAgent,
		'origin: https://www.instagram.com',
		'referer: https://www.instagram.com/accounts/login/',
		'x-csrftoken: '.$parse->config->csrf_token,
		'x-instagram-ajax: '.$parse->rollout_hash,
		'x-requested-with: XMLHttpRequest'
	));
	curl_setopt($curlHandler, CURLOPT_URL, 'https://www.instagram.com/accounts/login/ajax/');
	curl_setopt($curlHandler, CURLOPT_POST, 1);
	curl_setopt($curlHandler, CURLOPT_POSTFIELDS, 'username='.urlencode($id).'&password='.urlencode($pw).'&next=/');
	$httpResult = curl_exec($curlHandler);
	curl_setopt($curlHandler, CURLOPT_POST, 0);
	curl_setopt($curlHandler, CURLOPT_POSTFIELDS, NULL);
}

function requestFeed() {
	GLOBAL $curlHandler, $acceptLanguage, $userAgent, $cookieFile, $logFp2;
	$hashTagDir = '';
	$keyword = '';
    if( isset($_GET['hashTag']) && $_GET['hashTag']!='' ){
		$hashTagDir = 'explore/tags/';
		$keyword = str_replace(' ','',$_GET['hashTag']);
	}else if( isset($_GET['userID']) && $_GET['userID']!='' ){
		$hashTagDir = '';
		$keyword = str_replace(' ','',$_GET['userID']);
	}else{
		exit;
	}
    if(isset($_GET['maxId'])) {
        $request_url = 'https://www.instagram.com/'.$hashTagDir.urlencode($keyword).'/?__a=1&max_id='.$_GET['maxId'];
    } else {
        $request_url = 'https://www.instagram.com/'.$hashTagDir.urlencode($keyword).'/?__a=1';
	}
	curl_setopt($curlHandler, CURLOPT_URL, $request_url);
	curl_setopt($curlHandler, CURLOPT_HTTPHEADER, Array(
		//'accept: application/json',
		'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
		'accept-encoding: gzip, deflate, br',
		'accept-language: ko-KR,ko;q=0.9,en-US;q=0.8,en;q=0.7',
		'cache-control: max-age=0',
		'sec-fetch-mode: navigate',
		'sec-fetch-site: none',
		'sec-fetch-user: ?1',
		'upgrade-insecure-requests: 1',
		'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36'
	));
	curl_setopt($curlHandler, CURLOPT_COOKIEJAR, $cookieFile);
	curl_setopt($curlHandler, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlHandler, CURLOPT_VERBOSE, 1);
	curl_setopt($curlHandler, CURLOPT_STDERR, $logFp2);
	curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curlHandler, CURLOPT_SSL_VERIFYHOST, 0);
    $result = curl_exec($curlHandler);
	$code = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);
    curl_close($curlHandler);
	echo $result;exit;
	return $result;
}

$acceptLanguage = 'en-US,en;q=0.9,ko;q=0.8';
$userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36';
$cookieFile = __DIR__.'/cookie/cookie2.txt';//쿠키파일
$fileHandle = fopen($cookieFile, "w");
fwrite($fileHandle, '');
fclose($fileHandle);
$logFp1 = fopen(__DIR__.'/log/login.txt', 'w');//로그파일1
$logFp2 = fopen(__DIR__.'/log/feed2.txt', 'w');//로그파일2

$curlHandler = curl_init();
// $re = IGSetToken('ui@view3.net','dkanrjsk25');
$result = json_decode(requestFeed());

// 20180104 인스타그램 json 형식이 바뀌는 바람에 데이타 재가공
$feed = $result->graphql->hashtag->edge_hashtag_to_media->edges;
$temp_data = array();
for($i=0; $i<count($feed); $i++) {
	$temp_data[$i] = array(
		'code' => $feed[$i]->node->shortcode,
		'display_src' => $feed[$i]->node->thumbnail_src,
		'caption' => $feed[$i]->node->edge_media_to_caption->edges[0]->node->text,
		'likes' => array(
			'count' => $feed[$i]->node->edge_liked_by->count
		),
		'comments' => array(
			'count' => $feed[$i]->node->edge_media_to_comment->count
		)
	);
}
$result->entry_data->TagPage[0]->tag->media->nodes = $temp_data;
$result->entry_data->TagPage[0]->tag->media->page_info->end_cursor = $result->graphql->hashtag->edge_hashtag_to_media->page_info->end_cursor;
?>
<?=$_GET['callback'];?>(<?=json_encode($result);?>);