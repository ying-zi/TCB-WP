<?php

namespace DouYin;

class DouYin {
    public function getvideo($dy) {
        if ($dy) {
            preg_match('/[a-zA-z]+:\/\/[^\s]*/', $dy, $url);
            if (preg_match('/v.douyin.com/', $url[0]) == 1) {
		    $loc = get_headers($url[0], true)['location'];
                    $start = 'video/';
                    $end = '/?region';
                    $id = $this->get_id($loc,$start,$end);
                    $arr = json_decode($this->get_url("https://www.iesdouyin.com/web/api/v2/aweme/iteminfo/?item_ids=$id"), true);
                    $title = $arr['item_list'][0]["share_info"]["share_title"];
                    $music = $arr['item_list'][0]['music']['play_url']["url_list"][0];
                    $cover = $arr['item_list'][0]['video']["origin_cover"]["url_list"][0];
		    $videourl = str_replace('playwm', 'play', $arr['item_list'][0]["video"]["play_addr"]["url_list"][0]);
                    preg_match('/href="(.*?)">Found/', $this->get_url($videourl), $playurl);

                    $res = array(
                        'code' => 200,
                        'title' => $title,
                        'url' => $videourl,
                        'play' => $playurl[1],
                        'music' => $music,
                        'pic' => $cover,
                        'msg' => '解析成功'
                    );
            } else {
                $res = array(
                    'code' => 201,
                    'msg' => '请输入正确的抖音视频链接'
                );
            }
        } else {
            $res = array(
                'code' => 201,
                'msg' => '请输入抖音链接'
            );
        }
        return $res;
    }
    
    // 获取视频id
    function get_id($content,$start,$end) {
        $r = explode($start, $content);
        if (isset($r[1])) {
        $r = explode($end, $r[1]);
        return $r[0];
        }
        return '';
    }
	function get_url($url) {
		$Header=array("User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 14_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$Header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$result =  curl_exec($ch);
		curl_close ($ch);
		$result=mb_convert_encoding($result, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
		return $result;
	}
}
?>
