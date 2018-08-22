<?php
/**
 * 打印自定义常量
 */
function print_const(){
    $const = get_defined_constants(true);
    p($const['user']);
}

/**
 * @param $error            [错误信息]
 * @param string $level     [错误等级]
 * @param int $type         [错误类型]
 * @param null $dest        [写入地址]
 */
function halt($error, $level='ERROR', $type=3, $dest=NULL){
    if(is_array($error)){
        Log::write($error['message'], $level, $type, $dest);
    }else{
        Log::write($error, $level, $type, $dest);
    }
    $e = array();
    if(DEBUG){
        if(!is_array($error)){
            $trace = debug_backtrace();
            $e['message']   = $error;
            $e['file']      = $trace[0]['file'];
            $e['line']      = $trace[0]['line'];
            $e['class']     = isset($trace[0]['class'])? $trace[0]['class'] : '';
            $e['function']  = isset($trace[0]['function'])? $trace[0]['function'] : '';
            ob_start();
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            $e['trace']     = htmlspecialchars(ob_get_clean());
        }else{
            $e = $error;
        }
    }else{
        if($url = C('ERROR_URL')){
            go($url);
        }else{
            $e['message'] = C('ERROR_MSG');
        }
    }
    include DATA_VIEW.'/halt.php'; die;
}

/**
 * 跳转函数
 * @param $url          [跳转地址]
 * @param int $time     [跳转时间]
 * @param string $msg   [提示]
 */
function go($url, $time=0, $msg=''){
    if(!headers_sent()){    // 检测头部是否发送
        $time == 0 ? header('Location:'.$url) : header("refresh:{$time};url={$url}");
        die($msg);
    }else{
        echo "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time) die($msg);
    }
}

/**
 * 打印函数
 * @param $arr
 */
function p($arr){
    if(is_bool($arr)){
        var_dump($arr);
    }else if (is_null($arr)){
        var_dump(NULL);
    }else{
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}

/*
 * 1. 加载配置项
 * C($sysConfig) C($userConfig)
 * 2. 读取配置项
 * C('CODE_LIN')
 * 3. 临时动态改变配置项
 * C('CODE_LINE',20)
 * 4. 返回所有配置项参数
 * C()
 * */
function C($var = NULL, $value = NULL){
    static $config = array();
    //加载配置项
    if(is_array($var)){
        $config = array_merge($config,array_change_key_case($var,CASE_UPPER));
        return;
    }
    //读取或者动态改变配置项
    if(is_string($var)){
        $var = strtoupper($var);
        //两个参数传递
        if(!is_null($value)){
            $config[$var] = $value;
            return;
        }
        return isset($config[$var]) ? $config[$var] : NULL;
    }
    //返回所有配置项
    if(is_null($var) && is_null($value)){
        return $config;
    }
}

/**
 * 实例化模型
 * @param $table
 * @return Model
 */
function M($table){
    $obj  = new Model($table);
    return $obj;
}

/**
 * 实例化用户 扩展模型
 * @param $model
 * @return mixed
 */
function K($model){
    $model.='Model';
    $model = new $model;
    return new $model;
}
?>