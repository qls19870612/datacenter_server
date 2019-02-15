<?php


ini_set('memory_limit', '1000M');
set_time_limit(600);


/**
 * db 数据库配置
 */
$GLOBALS['DB'] = array(
    'Mysql' => array(
        'driver' => 'mysqli',
        'Host' => '134.175.127.247',
        'Port' => 3306,
        'User' => 'root',
        'Password' => 'wjssqlmm',
        'DBName' => 'datacenter',
        'Charset' => 'utf8'
    ),
	'diablo' => array(
        'driver' => 'mysqli',
        'Host' => '134.175.127.247',
        'Port' => 3306,
        'User' => 'root',
        'Password' => 'wjssqlmm',
        'DBName' => 'dbdiablomuzhiresult',
        'Charset'=>'utf8'
));
