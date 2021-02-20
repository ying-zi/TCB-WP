<?php
namespace Action;
use HY\Action;
class Index extends Action {
	public function Index(){
		$this->display("index");
	}
	public function mod(){
		if(IS_POST)
			echo '用户采用了POST访问';
		elseif(IS_GET)
			echo '用户采用了GET访问';
		elseif(IS_AJAX)
			echo '用户采用了AJAX访问';
      }
}