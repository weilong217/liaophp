<?php
/*
 * 父类 controller
 * */
class Controller extends SmartyView {
    private $var = [];
    /**
     * Controller constructor.
     */
    public function __construct(){
        if (C('SMARTY_ON')){
            parent::__construct();
        }

        if(method_exists($this,'__init')){
            $this->__init();
        }
        if(method_exists($this,'__auto')){
            $this->__auto();
        }
    }

    /**
     * 数据指派
     * @param $var      [属性]
     * @param $value    [属性值]
     */
    protected function assign($var, $value){
        if (C('SMARTY_ON')){
            parent::assign($var, $value);
        }else{
            $this->var[$var] = $value;
        }
    }

    protected function get_tpl($view){
        if(is_null($view)){
            $path = APP_VIEW_PATH . '/' . strtolower(CONTROLLER) . '/' . ACTION . '.php';
        }else{
            $suffix = strrchr($view, '.');
            empty($suffix) ? $view . '.php' : $view;
            $path = APP_VIEW_PATH . '/' . strtolower(CONTROLLER) . '/' . $view;
        }
        return $path;
    }

    /**
     * 视图载入
     * @param string|NULL $view
     */
    protected function display(string $view=NULL){
        $path = $this->get_tpl($view);
        if(!is_file($path)) halt($path.'模板文件不存在');
        if (C('SMARTY_ON')){
            parent::dispaly($path);
        }else{
            extract($this->var);
            include $path;
        }
    }

    /**
     * 成功提示方法
     * @param $msg      [提示消息]
     * @param null $url [跳转链接]
     * @param int $time [跳转时间]
     */
    protected function success(string $msg, string $url=NULL, int $time=3){
        $url = $url ? "window.location.href='".$url."'" : "window.history.back(-1)";
        include APP_VIEW_PATH.'/success.php'; die;
    }

    /**
     * 失败提示方法
     * @param $msg      [错误消息]
     * @param null $url [跳转链接]
     * @param int $time [跳转时间]
     */
    protected function error(string $msg, string $url=NULL, int $time=3){
        $url = $url ? "window.location.href='".$url."'" : "window.history.back(-1)";
        include APP_VIEW_PATH.'/error.php'; die;
    }
}
?>