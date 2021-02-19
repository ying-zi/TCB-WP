<?php
/******核心函数文件******/

	define('NAPI_PATH', __DIR__);
	//加载类库文件
	require_once(NAPI_PATH.'/extend/autoloader.php');
	Autoloader::register();
	// 获取参数 支持'GET'和'POST'
	$api = $_GET['api']?:Header('Location: home.html');
	$key = $_GET['key']?:$_POST['key'];
	$type = $_GET['type']?:$_POST['type'];
	$limit = $_GET['qty']?:$_POST['qty']?:'30';
	$API = new \MusicApi\meting($type);
	$NAPI = new \MusicApi\musicapi();
	// 以JSON格式输出
//	header('Content-type: text/json;charset=utf-8');
	switch ($api) {
		case 'qrcode': // 获取二维码
			$key = $key?:'https://yingzi.email';
			\QrCode\qrcode::png($key,false,QR_ECLEVEL_L,10,1);
		exit;
		case 'ip': // 以IP地址或域名获取城市名称
			$API = new \GetIpInfo\getipinfo(NAPI_PATH.'/static/ip/qqwry.dat');
			$key = $key?:$API->getip();
			$location = $API->getlocation($key);
			$info = array(
				'ip'=>$key,
				'city'=>$location['area'],
				'isp'=>$location['operators']
			);
			echo json_encode($info,JSON_UNESCAPED_UNICODE);
		exit;			
		case 'douyin': // 获取二维码
			$API = new \DouYin\douyin();
			$data = $API->getvideo($key);
			if ($type == 'url') {
				Header("Location:".$data['play']);
			} elseif ($type == 'pic') {
				Header("Location:" .$data['pic']);
			} else {
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
			}
		exit;
		case 'so': // 模糊搜索
			$data = json_decode($API->format(1)->search($key,['limit'=>$limit]), true);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		exit;
		case 'name': // 歌名搜索
			echo json_encode($NAPI->mc_get_song_by_name($key, $type), JSON_UNESCAPED_UNICODE);
		exit;
		case 'album': // 专辑
			$data = json_decode($API->format(1)->album($key),true);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		exit;
		case 'list': // 播放列表
			$data = json_decode($API->format(1)->playlist($key),true);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		exit;
		case 'mp3': // 歌曲链接
			$data = json_decode($API->format(1)->url($key), true);
			$url = $data['url'];
			if ($type == 'netease') {
				$url = str_replace('http://', 'https://', $url);
				$url = str_replace(array('https://m7c.','https://m8c.'),'https://m9.',$url);
			}
			if ($type == 'tencent') $url = str_replace("http://ws.stream.qqmusic.qq.com/", "https://dl.stream.qqmusic.qq.com/", $url);
			Header("Location:" . $url);
		exit;
		case 'url': // 歌曲链接
			$data = json_decode($API->format(1)->url($key), true);
			$info = $NAPI->mc_get_song_by_id($key, $type);
			$url = ($type == 'kugou')?$info['0']['url']:$data['url'];
			if ($type == 'netease') {
				$url = str_replace('http://', 'https://', $url);
				$url = str_replace(array('https://m7c.','https://m8c.'),'https://m9.',$url);
			}
			if ($type == 'tencent') $url = str_replace("http://ws.stream.qqmusic.qq.com/", "https://dl.stream.qqmusic.qq.com/", $url);
			Header("Location:" . $url);
		exit;
		case 'pic': // 封面链接
			$data = json_decode($API->pic($key), true);
			$info = $NAPI->mc_get_song_by_id($key, $type);
			$pic = ($type == 'kugou')?$info['0']['pic']:$data['url'];
			Header("Location:" . $pic);
		exit;
		case 'lrc': // 歌词
			$data = json_decode(str_replace(array('\\r\\n', '\\r', '\\n', '\"'), '', $API->format(1)->lyric($key)), true);
			$lrc = preg_replace("@(\w+)?\.?(\w+)\.(com|org|info|net|cn|biz|cc|uk|tk|jp|la|ru|us|ws)@U", 'WWW.NAPI.LTD', $data['lyric']);
			$tlrc = preg_replace("@(\w+)?\.?(\w+)\.(com|org|info|net|cn|biz|cc|uk|tk|jp|la|ru|us|ws)@U", 'WWW.NAPI.LTD', $data['tlyric']);
			$lrc = preg_replace("@(\d+){5,11}@", '***********', $lrc);
			$tlrc = preg_replace("@(\d+){5,11}@", '***********', $tlrc);
			if($lrc){
				if(!strstr($lrc,"[")){
					echo 'var lrc = "[00:00.01]歌词不支持滚动[99:99.99]WWW.NAPI.LTD";';
					echo 'var tlrc = "[00:00.01]歌词不支持滚动[99:99.99]WWW.NAPI.LTD";';
				}else{
					echo 'var lrc = "[00:00.01]歌词由 YingZi 提供' . $lrc . '[99:99.99]WWW.NAPI.LTD";';
					echo 'var tlrc = "[00:00.01]歌词由 YingZi 提供' . $tlrc . '[99:99.99]WWW.NAPI.LTD";';
				}
			}else{
				echo 'var lrc = "[00:00.01]暂无歌词[99:99.99]WWW.NAPI.LTD";';
				echo 'var tlrc = "[00:00.01]暂无歌词[99:99.99]WWW.NAPI.LTD";';
			}
		exit;
		case 'rgb': // 图片RGB
			$url = str_replace("https", "http", $key);
			$imageInfo = getimagesize($url);
			$imgType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
			$imageFun = 'imagecreatefrom' . ($imgType == 'jpg' ? 'jpeg' : $imgType);
			$i = $imageFun($url);
			$rColorNum = $gColorNum = $bColorNum = 0;
			for ($x = 0; $x < imagesx($i); $x++) {
				for ($y = 0; $y < imagesy($i); $y++) {
					$rgb = imagecolorat($i, $x, $y);
					$rColorNum += $rgb >> 16 & 0xff;
					$gColorNum += $rgb >> 8 & 0xff;
					$bColorNum += $rgb & 0xff;
				}
			}
			$rgb = array();
			$rgb['r'] = round($rColorNum / ($x*$y));
			$rgb['g'] = round($gColorNum / ($x*$y));
			$rgb['b'] = round($bColorNum / ($x*$y));
			$R = (abs(255 - $rgb['r']*2) < 100) ? abs($rgb['r'] - 88) : (255 - $rgb['r']);
			$G = (abs(255 - $rgb['g']*2) < 100) ? abs($rgb['g'] - 88) : (255 - $rgb['g']);
			$B = (abs(255 - $rgb['b']*2) < 100) ? abs($rgb['b'] - 88) : (255 - $rgb['b']);
			echo "var mainColor = '" . $rgb['r'] . "," . $rgb['g'] . "," . $rgb['b'] . "';";
			echo "var font_color = '" . $R . "," . $G . "," . $B . "';";
		exit;
	}
?>
