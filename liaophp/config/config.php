<?php
return [
    'CODE_LINE' => 5,

    /* 默认时区 */
    'DEFAULT_TIME_ZONE'     =>      'PRC',
    /* session自动开启 */
    'SESSION_AUTO_START'    =>      true,

    /* 默认控制器占用字母 */
    'VAR_CONTROLLER'        =>      'c',
    /* 默认方法占用字母 */
    'VAR_ACTION'            =>      'a',

    /* 是否开启日志 */
    'SAVE_LOG'              =>      true,

    /* 错误跳转地址 */
    'ERROR_UTL'             =>      '',
    /* 错误提示 */
    'ERROR_MSG'             =>      '发生错误',

    /* 自动加载 common/lib 目录下的文件，数值形式 */
    'AUTO_LOAD_FILE'        =>      [],

    /* Smarty 配置项 */
    'SMARTY_ON'             =>      false,
    'LEFT_DELIMITER'        =>      '{',
    'RIGHT_DELIMITER'       =>      '}',
    'CACHE_ON'              =>      false,
    'CACHE_TIME'            =>      60,

    /* 数据库相关配置 */
    'DB_CHARSET'            =>      'utf8',
    'DB_HOST'               =>      '127.0.0.1',
    'DB_PORT'               =>      3306,
    'DB_USER'               =>      'root',
    'DB_PASSWORD'           =>      '',
    'DB_DATABASE'           =>      '',
    'DB_PREFIX'             =>      ''
];