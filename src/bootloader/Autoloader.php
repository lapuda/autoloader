<?php
/**
 * Created by PhpStorm.
 * User: noah
 * Date: 18/4/18
 * Time: 16:27
 */

namespace bootloader;

/**
 * Class Autoloader
 * @package Bootstrap
 */
class Autoloader{

    protected static $sysRoot = array();
    protected static $instance;
    protected $classPrefixes = array();

    protected function __construct()
    {
        static::$sysRoot = [
            __DIR__.'/../../',//默认的项目根目录
            __DIR__.'/../'// vendor目录
        ];
    }

    /**
     * 返回一个自己的实例.
     *
     * @return self
     */
    public static function instance()
    {
        if(!static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * 添加根目录. 默将使用Autoloader目录所在的上级目录为根目录。
     *
     * @param string $path
     *
     * @return Autoloader
     */
    public function addRoot($path)
    {
        static $called;
        if(!$called) {
            // 取消默认的项目根目录
            unset(static::$sysRoot[0]);
            $called = true;
        }
        static::$sysRoot[] = $path;
        return $this;
    }

    /**
     * 按命名空间自动加载相应的类.
     *
     * @param string $name 命名空间及类名
     * @return boolean
     */
    public function loadByNamespace($name)
    {
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR ,$name);
        foreach(static::$sysRoot as $k => $root) {
            foreach (['.inc','.php'] as $ext) {
                $classFile = $root . $classPath . $ext;
                if (is_file($classFile)) {
                    require_once($classFile);
                    if (class_exists($name, false)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * 初始化并注册自动装载的方法.
     *
     * @return \bootloader\Autoloader
     */
    public function init()
    {
        spl_autoload_register([$this, 'loadByNamespace']);
        return $this;
    }
}