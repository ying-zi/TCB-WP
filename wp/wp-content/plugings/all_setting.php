<?php
/*
Plugin Name: N-API
Plugin URI: https://www.napi.ltd/
Version: 1.0
Author: YingZi
Author URI: https://www.napi.ltd/
Description:开启 WordPress 隐藏的设置项“全部设置”，用以更改云开发初次安装后为英文版的问题。语言更改为中文后可删除本插件。
*/

function all_settings_link() {
	add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
}
add_action('admin_menu', 'all_settings_link');