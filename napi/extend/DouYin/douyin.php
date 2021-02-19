<?php

namespace DouYin;

class DouYin{
	public function getinfo($url) {
		if(empty($url)){
			return $this->error('请输入抖音复制的链接后操作');
		}
		if (preg_match('/v.douyin.com\/(.*?)\//',$url,$match)){
			$url = 'https://v.douyin.com/' . $match[1];
			$html = $this->curlHelper($url);
			$url = $html['detail']['redirect_url'];
			if(preg_match('/video\/(.*?)\//',$url,$match_vid)){
				$video_id = $match_vid[1];
				$html = $this->curlHelper("https://www.douyin.com/web/api/v2/aweme/iteminfo/?item_ids=".$video_id,null,['']);
				$VideoData = json_decode($html['body'],true);
				if($VideoData['status_code']==0){
					$AuthorId = $VideoData['item_list'][0]['author']['unique_id'];
					$AuthorName = $VideoData['item_list'][0]['author']['nickname'];
					$AuthorSig = $VideoData['item_list'][0]['author']['signature'];
					$AuthorCover = $VideoData['item_list'][0]['author']['avatar_larger']['url_list'][0];
					$MusicAuthor = $VideoData['item_list'][0]['music']['author'];
					$MusicTitle = $VideoData['item_list'][0]['music']['title'];
					$MusicUrl = $VideoData['item_list'][0]['music']['play_url']['uri'];
					$VideoTitle = $VideoData['item_list'][0]['desc'];
					$VideoCover = $VideoData['item_list'][0]['video']['origin_cover']['url_list'][0];
					$VideoUrl = $VideoData['item_list'][0]['video']['play_addr']['url_list'][0];
					if(!$VideoUrl){
						return $this->error('解析JSON数据出现问题，获取失败');
					}
					$VideoUrl = str_replace('playwm','play',$VideoUrl);
					$PlayUrl = false;
					for($i=0;$i<10;$i++){
						//最多尝试10次获取
						$html = $this->curlHelper($VideoUrl);
						if(!empty($html['body'])){
							$html = $html['body'];
							if(preg_match('/<a href="(.*?)">/',$html,$match_url)){
								$PlayUrl = $match_url[1];
							}
							break;
						}
					}
					if(!$PlayUrl){
						return $this->error('请复制到浏览器打开,如果白屏,请多次刷新尝试!',301);
					}
					$Author = array(
						'id' => $AuthorId,
						'name' => $AuthorName,
						'sig' => $AuthorSig,
						'pic' => $AuthorCover
					);
					$Video = array(
						'title' => $VideoTitle,
						'url' => $VideoUrl,
						'play' => $PlayUrl,
						'pic' => $VideoCover
					);
					$Music = array(
						'author' => $MusicAuthor,
						'title' => $MusicTitle,
						'url' => $MusicUrl
					);
					return $this->success($Author, $Video, $Music, '获取成功');
				}else{
					return $this->error('没有查找到视频地址，请查看该抖音是否公开');
				}
			}else{
				return $this->error('没有查找到视频地址，请查看该抖音是否公开');
			}
		}else {
			return $this->error ('你输入的链接有误，没有识别到抖音链接');
		}
	}
	/**
	 * 输出正常JSON
	@return json
	 */
	private function success($Author, $Video = null, $Music, $msg){
			return json_encode (["code"=>200, 'author' => $Author, 'video' => $Video, 'music' => $Music, "msg"=>$msg], JSON_UNESCAPED_UNICODE);
		die ;
	}
	/**
	 * 输出错误JSON
	@return json
	 */
	private function error($msg='error',$code=500){
			return json_encode (["code"=>$code, "msg"=>$msg], JSON_UNESCAPED_UNICODE);
		die ;
	}
	private function curlHelper($url,$data=null,$header=[],$cookies="",$method='GET'){
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL ,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER ,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST ,false);
		$header[] = 'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 11_1_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36';
		curl_setopt($ch,CURLOPT_HTTPHEADER ,$header);
		curl_setopt($ch,CURLOPT_COOKIE ,$cookies);
		switch ($method){
			case  "GET":
				curl_setopt($ch,CURLOPT_HTTPGET ,true);
				break ;
			case  "POST":
				curl_setopt($ch,CURLOPT_POST ,true);
				curl_setopt($ch,CURLOPT_POSTFIELDS ,$data);
				break ;
			case  "PUT":
				curl_setopt($ch,CURLOPT_CUSTOMREQUEST ,"PUT");
				curl_setopt($ch,CURLOPT_POSTFIELDS ,$data);
				break ;
			case  "DELETE":
				curl_setopt($ch,CURLOPT_CUSTOMREQUEST ,"DELETE");
				curl_setopt($ch,CURLOPT_POSTFIELDS ,$data);
				break ;
			case  "PATCH":
				curl_setopt($ch,CURLOPT_CUSTOMREQUEST ,"PATCH");
				curl_setopt($ch,CURLOPT_POSTFIELDS ,$data);
				break ;
			case  "TRACE":
				curl_setopt($ch,CURLOPT_CUSTOMREQUEST ,"TRACE");
				curl_setopt($ch,CURLOPT_POSTFIELDS ,$data);
				break ;
			case  "OPTIONS":
				curl_setopt($ch,CURLOPT_CUSTOMREQUEST ,"OPTIONS");
				curl_setopt($ch,CURLOPT_POSTFIELDS ,$data);
				break ;
			case  "HEAD":
				curl_setopt($ch,CURLOPT_CUSTOMREQUEST ,"HEAD");
				curl_setopt($ch,CURLOPT_POSTFIELDS ,$data);
				break ;
			default :
		}
		curl_setopt($ch,CURLOPT_RETURNTRANSFER ,1);
		curl_setopt($ch,CURLOPT_HEADER ,1);
		$response=curl_exec($ch);
		$output=[];
		$headerSize=curl_getinfo($ch,CURLINFO_HEADER_SIZE );
		// 根据头大小去获取头信息内容
		$output['header']=substr($response,0,$headerSize);
		$output['body']=substr($response,$headerSize,strlen($response)-$headerSize);
		$output['detail']=curl_getinfo($ch);
		curl_close($ch);
		return $output;
	}
}


$key = $_GET['key']?:$_POST['key'];
$type = $_GET['type']?:$_POST['type'];

$API = new \DouYin\douyin();
$data = json_decode($API->getinfo($key), true);
if ($type == 'url') {
Header("Location:".$data['video']['play']);
} elseif ($type == 'pic') {
	Header("Location:" .$data['video']['pic']);
} else {
        header('Content-type: text/json;charset=utf-8');
	echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
?>
