<?php
class SmartyView{
    private static $smarty = NULL;

    public function __construct()
    {
        if (!is_null(self::$smarty)) return;
        $smarty = new Smarty();
        // 模板目录
        $smarty->template_dir   =   APP_VIEW_PATH . '/' . CONTROLLER .'/';
        // 编译目录
        $smarty->compile_dir    =   APP_COMPILE_PATH;
        // 缓存目录
        $smarty->cache_dir      =   APP_CACHE_PATH;
        // 定界符
        $smarty->left_delimiter =   C('LEFT_DELIMITER');
        $smarty->right_delimiter=   C('RIGHT_DELIMITER');
        // 是否开启缓存
        $smarty->caching        =   C('CACHE_ON');
        // 缓存事件
        $smarty->cache_lifetime =   C('CACHE_TIME');

        self::$smarty = $smarty;
    }

    protected function dispaly($tpl){
        self::$smarty->display($tpl, $_SERVER['REQUEST_URI']);
    }

    protected function assign($var, $value){
        self::$smarty->assign($var, $value);
    }

    protected function is_cached($tpl=null){
        if(!C('SMARTY_ON')) halt('请先开启 Smarty!');
        $tpl = $this->get_tpl($tpl);
        return self::$smarty->is_cached($tpl, $_SERVER['REQUEST_URI']);
    }
}
?>