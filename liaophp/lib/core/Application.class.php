<?php

final class Application{
    public static function run(){
        self::_init();
        set_error_handler([__CLASS__, 'error']);                // 设置定义的错误处理函数
        register_shutdown_function([__CLASS__,'fatal_error']);  // php中止时执行的函数 （致命错误）
        self::_user_import();
        self::_set_url();
        spl_autoload_register(array(__CLASS__, '_autoload'));
        self::_create_demo();
        self::_app_run();
    }

    static function fatal_error(){
        if($e = error_get_last()){
            self::error($e['type'], $e['message'], $e['file'], $e['line']);
        }
    }

    /**
     * @param $errno    [错误级别]
     * @param $errstr   [错误信息]
     * @param $errfile  [错误文件]
     * @param $errline  [错误行号]
     */
    static function error($errno, $errstr, $errfile, $errline){
        switch ($errno){
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                $msg = $errstr . $errfile . " 第{$errline}行";
                halt($msg);
                break;
            case E_STRICT:
            case E_USER_WARNING:
            case E_USER_NOTICE:
            default:
                if(DEBUG){
                    include DATA_VIEW.'/notice.php';
                }
                break;
        }
    }

    /**
     * 载入用户自定义类库  commot/lib
     */
    private static function _user_import(){
        $fileArr = C('AUTO_LOAD_FILE');
        if (is_array($fileArr) && !empty($fileArr)){
            foreach ($fileArr as $v) {
                require_once COMMON_LIB_PATH.'/'.$v;
            }
        }
    }

    /*
     * 实例化应用控制器
     * */
    private static function _app_run(){
        $c = isset($_GET[C('VAR_CONTROLLER')]) ? ucfirst($_GET[C('VAR_CONTROLLER')]):  'Index';
        $a = isset($_GET[C('VAR_ACTION')]) ? $_GET[C('VAR_ACTION')] : 'index';
        define('CONTROLLER', $c);
        define('ACTION', $a);

        $c .= 'Controller';
        if(class_exists($c)){
            $obj = new $c();
            if(!method_exists($obj, $a)){
                if (method_exists($obj,'__empty')){
                    $obj->__empty();
                }else{
                    halt($c . '控制器中 ' . $a .' 方法不存在');
                }
            }else{
                $obj->$a();
            }
        }else{
            (new EmptyController())->$a();
        }
    }

    /*
     * 创建默认控制器
     * */
    private static function _create_demo(){
        $appName = APP_NAME;
        $path = APP_CONTROLLER_PATH.'/IndexController.class.php';
        $str = <<<str
<?php
class IndexController extends Controller{
    public function index(){
        header('Content-type:text/html; charset=utf-8');
        echo '<h2>欢迎使用LIAOPHP框架</h2>';
    }
}
?>
str;
        is_file($path) || file_put_contents($path, $str);
    }

    /*
     * 自动载入功能
     * */
    private static function _autoload($className){
        switch (true){
            // 判断是否为控制器
            case strlen($className)>10 && substr($className, -10)== 'Controller':
                $path = APP_CONTROLLER_PATH.'/'.$className.'.class.php';
                if (!is_file($path)) {
                    $emptyPath = APP_CONTROLLER_PATH .'/EmptyController.class.php';
                    if (is_file($emptyPath)){
                        include $emptyPath;
                        return;
                    }else{
                        halt($path.'控制器没有找到');
                    }
                };
                include $path;
                break;
            // 判断是否为模型
            case strlen($className)>5 && substr($className, -5)=='Model':
                $path = COMMON_MODEL_PATH.'/'.$className.'.class.php';
                include $path;
                break;

            default:
                $path = TOOL_PATH.'/'.$className . '.class.php';
                if (!is_file($path)) halt($path.'类没有找到');
                include $path;
                break;
        }
    }

    /*
     * 设置外部路径
     * */
    private static function _set_url(){
        $path = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
        $path = str_replace('\\','/',$path);
        define('__APP__',$path);
        define('__ROOT__', dirname(dirname(__APP__)).'/app');
        define('__VIEW__', __ROOT__.'/'.APP_NAME.'/view');
        define('__PUBLIC__', __VIEW__.'/public');
    }

    /*
     * 初始化框架
     * */
    private static function _init(){
        // 加载系统配置项
        C(include CONFIG_PATH.'/config.php');
        // 加载公共配置项
        $commonPath = COMMON_CONFIG_PATH . '/common.php';
        $commonConfig = <<<str
<?php
    return array(
        // 配置项=>配置值
    );
?>
str;
        is_file($commonPath) || file_put_contents($commonPath, $commonConfig);
        C(include $commonPath);
        // 加载用户配置项
        $userConfigPath = APP_CONFIG_PATH.'/config.php';
        $userConfig = <<<str
<?php
    return array(
        // 配置项=>配置值
    );
?>
str;
        is_file($userConfigPath) || file_put_contents($userConfigPath, $userConfig);
        C(include $userConfigPath);
        // 设置默认时区
        date_default_timezone_set(C('DEFAULT_TIME_ZONE'));
        // 是否开去SESSION
        C('SESSION_AUTO_START') && session_start();
    }
}
?>