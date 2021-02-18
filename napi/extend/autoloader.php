<?php

// 自动加载类库
class Autoloader {
    public static function register() {
        spl_autoload_register(array(new self, 'autoload'));
    }
    public static function autoload($className) {
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . $className;
        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $filePath) . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        } else {
            echo "无法加载" . $filePath;
        }
    }
}
?>