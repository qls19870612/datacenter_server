<?php


ini_set('memory_limit', '1000M');
set_time_limit(600);


/**
 * db 数据库配置
 */
$GLOBALS['DB'] = array(
    'Mysql' => array(
        'driver' => 'mysqli',
        'Host' => '127.0.0.1',
        'Port' => 3306,
        'User' => 'root',
        'Password' => '123456',
        'DBName' => 'datacenter',
        'Charset' => 'utf8'
    ),
	'diablo' => array(
        'driver' => 'mysqli',
        'Host' => '127.0.0.1',
        'Port' => 3306,
        'User' => 'root',
        'Password' => '123456',
        'DBName' => 'dbdiabloyyresult',
        'Charset'=>'utf8'
));
