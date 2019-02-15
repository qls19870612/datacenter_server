<?php

class MysqlDb {
    static public $serverConfig = array(
        'test' => array(
            'log' => array(
                'host' => '134.175.127.247',
                'user' => 'root',
                'password' => 'wjssqlmm',
                'port' => 3306,
            ),
            'result' => array(
                'host' => '134.175.127.247',
                'user' => 'root',
                'password' => 'wjssqlmm',
                'port' => 3306,
            )
        )
    );

    static public function getDbServer($game, $type) {
        if (isset(self::$serverConfig[$game]) && isset(self::$serverConfig[$game][$type])) {
            return new PDO('mysql:host=' . self::$serverConfig[$game][$type]['host'].';port='.self::$serverConfig[$game][$type]['port'],
                self::$serverConfig[$game][$type]['user'],
                self::$serverConfig[$game][$type]['password'],
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
        } else {
            return false;
        }
    }
}