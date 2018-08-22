<?php

final class Bootstrap{

    static function run(){
        self::_set_const();
        defined('DEBUG') || define('DEBUG', false);
        if(DEBUG){
            self::_create_dir();
            self::_import_file();
        }else{
            error_reporting(0);
            require TEMP_PATH . '/~boot.php';
        }
        // 执行引用类
        Application::run();
    }

    /*
     * 设置常量
     * */
    private static function _set_const(){
        $path = str_replace('\\','/',__FILE__);

        // 框架目录
        define('LIAOPHP_PATH', dirname($path));
        define('CONFIG_PATH', LIAOPHP_PATH.'/config');
        define('DATA_PATH', LIAOPHP_PATH.'/data');
        define('DATA_VIEW',DATA_PATH.'/view');
        define('LIB_PATH', LIAOPHP_PATH.'/lib');
        define('CORE_PATH', LIB_PATH.'/core');
        define('FUNCTION_PATH', LIB_PATH.'/function');

        // 项目目录
        define('ROOT_PATH', dirname(LIAOPHP_PATH));
        // 应用目录
        define('APP_PATH', ROOT_PATH.'/app/'.APP_NAME);
        define('APP_CONFIG_PATH', APP_PATH.'/config');
        define('APP_CONTROLLER_PATH', APP_PATH.'/controller');
        define('APP_VIEW_PATH', APP_PATH.'/view');
        define('APP_PUBLIC_PATH', APP_VIEW_PATH.'/public');

        // 临时目录
        define('TEMP_PATH', ROOT_PATH.'/temp');
        define('LOG_PATH', TEMP_PATH.'/log');
        define('APP_COMPILE_PATH', TEMP_PATH . '/'.APP_NAME . '/compile');  // smarty 编译目录
        define('APP_CACHE_PATH', TEMP_PATH . '/'.APP_NAME . '/cache');  // smarty 缓存 编译目录

        // IS_POST 与 IS_AJAX
        define('IS_POST', ($_SERVER['REQUEST_METHOD']=='POST'? true : false));
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
            define('IS_AJAX', true);
        }else{
            define('IS_AJAX', false);
        }

        // 公共常量
        define('COMMON_PATH', ROOT_PATH.'/common');
        // 公共配置项文件夹
        define('COMMON_CONFIG_PATH', COMMON_PATH.'/config');
        // 公共模型文件夹
        define('COMMON_MODEL_PATH', COMMON_PATH.'/model');
        // 公共库文件夹
        define('COMMON_LIB_PATH', COMMON_PATH.'/lib');

        // 框架扩展常量
        define('EXTEND_PATH', LIAOPHP_PATH . '/extends');
        define('ORG_PATH', EXTEND_PATH . '/org');
        define('TOOL_PATH', EXTEND_PATH . '/tool');

        // 框架版本 V-主版本-次版本-修订次数
        define('LIAOPHP_VERSION', 'LIAOPHP V-1.0.0');
    }

    /*
     * 创建文件夹
     * */
    private static function _create_dir(){
        $array = [
            COMMON_PATH,
            COMMON_CONFIG_PATH,
            COMMON_MODEL_PATH,
            COMMON_LIB_PATH,
            APP_PATH,
            APP_CONFIG_PATH,
            APP_CONTROLLER_PATH,
            APP_VIEW_PATH,
            APP_PUBLIC_PATH,
            TEMP_PATH,
            APP_COMPILE_PATH,
            APP_CACHE_PATH,
            LOG_PATH
        ];
        foreach ($array as $v){
            is_dir($v) || mkdir($v, 0777, true);
        }

        is_file(APP_VIEW_PATH.'/success.php') || copy(DATA_VIEW.'/success.php',APP_VIEW_PATH.'/success.php');
        is_file(APP_VIEW_PATH.'/error.php') || copy(DATA_VIEW.'/error.php',APP_VIEW_PATH.'/error.php');
        is_file(APP_VIEW_PATH.'/halt.php') || copy(DATA_VIEW.'/halt.php',APP_VIEW_PATH.'/halt.php');
        is_file(APP_VIEW_PATH.'/notice.php') || copy(DATA_VIEW.'/notice.php',APP_VIEW_PATH.'/notice.php');
    }

    /*
     * 载入必须文件
     * */
    private static function _import_file(){
        $fileArr = [
            CORE_PATH.'/Log.class.php',
            FUNCTION_PATH.'/function.php',
            ORG_PATH .'/smarty/Smarty.class.php',
            CORE_PATH.'/SmatryView.class.php',
            CORE_PATH.'/Controller.class.php',
            CORE_PATH.'/Application.class.php',
        ];
        $str = '';
        foreach ($fileArr as $v){
            $str.= substr(file_get_contents($v),5, -2);
            require($v);
        }
        $str = "<?php\r\n".$str;
        file_put_contents(TEMP_PATH. '/~boot.php', $str) || die('access not allow');
    }
}

Bootstrap::run();
?>