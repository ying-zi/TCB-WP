<?php
namespace Action;
use HY\Action;
class Api extends Action {
	public function Douyin(){
		$DouyinLib = L("Douyin");
		$data = $DouyinLib->getinfo(X("get.key"));
		if (X("get.type") == 'url'){
			Header("Location:" .$data['video']['play']);
		} elseif (X("get.type") == 'pic'){
			Header("Location:" .$data['video']['pic']);
		} else  {
			echo $this->json($data);
		}
	}
	public function Ip(){
		$IpLib = L("Ip");
		$location = $IpLib->getlocation(X("get.key", $IpLib->getip()));
		$info = array(
			'ip'=>X("get.key", $IpLib->getip()),
			'city'=>$location['area'],
			'isp'=>$location['operators']
		);
		echo $this->json($info);
	}
	public function Qrcode(){
		$QrcodeLib = L("Qrcode");
		$QrcodeLib->png(X("get.key", $_SERVER['HTTP_HOST']),false,QR_ECLEVEL_L,10,1);
	}
}	