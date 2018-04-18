<?php
/**
 * Created by PhpStorm.
 * User: noah
 * Date: 18/4/18
 * Time: 16:27
 */

define("WEB_ROOT",__DIR__.DIRECTORY_SEPARATOR);//项目根目录
define("VENDOR_ROOT",WEB_ROOT."../src".DIRECTORY_SEPARATOR);// 类库目录

require_once VENDOR_ROOT."bootloader/Autoloader.php";//引入自动装载类

// 初始化
bootloader\Autoloader::instance()
    ->addRoot(WEB_ROOT)
    ->addRoot(VENDOR_ROOT)
    ->init();

$demo = new \demo\Test;
$demo->test();