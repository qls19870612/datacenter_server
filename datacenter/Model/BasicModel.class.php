<?php

/**
 * model基类 (对 db操作对象 进行初始化)
 * Class BasicModel
 */
class BasicModel extends ModelBase
{
    /**
     * 操作库操作对象
     * @var TSQL_mysqli $_db
     */
    protected $_db;

    public function  __construct()
    {
        $this->_db = TSQL::initDB('mysql');
    }


}