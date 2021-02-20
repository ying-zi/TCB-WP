<?php
namespace Action;
use HY\Action;
class No extends Action {
	public function Index(){
		echo '你访问的控制器不存在!';
	}
    public function _no(){
        echo '你访问的函数未定义!';
    }
}