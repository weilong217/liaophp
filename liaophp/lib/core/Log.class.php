<?php

/**
 * 日志处理
 * Class Log
 */
class Log{
    /**
     * @param $msg              [错误消息]
     * @param string $level     [错误等级]
     * @param int $type         [错误类型]
     * @param null $dest        [写入地址]
     */
    static public function write($msg, $level='ERROR', $type=3, $dest=null){
        if(!C('SAVE_LOG')) return;
        if(is_null($dest)){
            $dest = LOG_PATH.'/'.date('Y-m-d').'.log';
        }
        if(is_dir(LOG_PATH)) error_log(date('Y-m-d H:i:s') . " [{$level}]{$msg}\r\n", $type, $dest);
    }
}
?>