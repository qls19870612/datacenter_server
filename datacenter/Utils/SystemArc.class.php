<?php

/**
 * 系统权限控制
 * Class SystemArc
 */
class SystemArc extends ARC
{


    private $_db;

    public function  __construct()
    {
        $this->_db = TSQL::initDB('Mysql'); //初始化db对象
		$this->ACCOUNT_FIELDS=array('id','username','password','status','nickname','createtime');
    }


    /**
     * C_GET
     * 定义用户自已编写的读取方法
     *
     * @param string $TYPE 要读取的类型,ACCOUNT|ROLE|ROLE_GROUP|ACCESS|ACCESS_GROUP
     * @var string [...] 后续参数格式为field|value,可以无限个,注意,这里的关系是同时成立的条件,而不是多选条件
     * return mixed
     */
    public function C_GET($TYPE, $cond, $offset = 0, $count = 0)
    {
        //这里模拟用户自行编写一个读写类
        $TYPE = strtoupper($TYPE);
        if (!in_array($TYPE, array('ACCOUNT', 'ROLE', 'ROLEGROUP', 'ACCESS', 'ACCESSGROUP', 'ACCOUNTROLE', 'ACCOUNTACCESS', 'ROLEACCESS'))) {
            return NULL;
        }
        $alisaname = $TYPE . "_ALISANAME";

        $this->_db->reset()->table($this->$alisaname);
        if ($cond) {
            $where = array();
            foreach ($cond as $fieldname => $fieldvalue) {
                $where[] = is_null($fieldvalue) ? ($fieldname . ' IS NULL') : ($fieldname . "='" . $fieldvalue . "'");
            }
            $this->_db->Where(implode(' AND ', $where));
        }
        if (intval($count)) {
            $this->_db->Limit(intval($offset), intval($count));
        }
        return $this->_db->fetchAll();
    }


    /**
     * C_SAVE
     * 定义用户自已编写的保存方法
     *
     * @param string $TYPE 要保存的类型,ACCOUNT|ROLE|ROLE_GROUP|ACCESS|ACCESS_GROUP
     * @var string [...] 后续参数格式为field|value,可以无限个,注意,这里的关系是同时成立的条件,而不是多选条件
     * return mixed
     */
    public function C_SAVE($TYPE, $fieldvalue)
    {
        //这里模拟用户自行编写一个读写类
        $TYPE = strtoupper($TYPE);
        if (empty($fieldvalue)) {
            return FALSE;
        }
        if (!in_array($TYPE, array('ACCOUNT', 'ROLE', 'ROLEGROUP', 'ACCESS', 'ACCESSGROUP', 'ACCOUNTROLE', 'ACCOUNTACCESS', 'ROLEACCESS'))) {
            return FALSE;
        }

        $alisaname = $TYPE . "_ALISANAME";
        $this->_db->reset()->table($this->$alisaname);
        $record = array();

        foreach ($fieldvalue as $fieldname => $fieldvalue) {
            $record[] = $fieldvalue;
            $this->_db->Fields($fieldname);
        }
        $result = $this->_db->Record($record)->save();
        return $result['status'];
    }


    /**
     * C_REMOVE
     * 自定义删除方法
     *
     * @param string $TYPE 要删除的类型,ACCOUNT|ROLE|ROLE_GROUP|ACCESS|ACCESS_GROUP
     * @var string [...] 后续参数格式为field|value,可以无限个,注意,这里的关系是同时成立的条件,而不是多选条件
     * return mixed
     */
    public function C_REMOVE($TYPE, $cond)
    {

        //这里模拟用户自行编写一个删除方法
        $TYPE = strtoupper($TYPE);
        if (!in_array($TYPE, array('ACCOUNT', 'ROLE', 'ROLEGROUP', 'ACCESS', 'ACCESSGROUP', 'ACCOUNTROLE', 'ACCOUNTACCESS', 'ROLEACCESS'))) {
            return NULL;
        }
        $alisaname = $TYPE . "_ALISANAME";

        $this->_db->reset()->table($this->$alisaname);
        if (!empty($cond)) {
            $where = array();
            foreach ($cond as $key => $v) {
                $where[] = is_null($v) ? ($key . " is NULL") : ($key . "='" . $v . "'");
            }
            $this->_db->Where(implode(' AND ', $where));
        }
        $result = $this->_db->Delete();
        return $result['status'];

    }


    /**
     * C_UPDATE
     * 自定义更新方法
     *
     * @param string $TYPE 要删除的类型,ACCOUNT|ROLE|ROLE_GROUP|ACCESS|ACCESS_GROUP
     * @param array $newValue 要更新的字段和值
     * @param array $cond 要更新的条件
     * return mixed
     */
    public function C_UPDATE($TYPE, $newValue, $cond)
    {

        //这里模拟用户自行编写一个更新方法
        $TYPE = strtoupper($TYPE);
        if (!in_array($TYPE, array('ACCOUNT', 'ROLE', 'ROLEGROUP', 'ACCESS', 'ACCESSGROUP', 'ACCOUNTROLE', 'ACCOUNTACCESS', 'ROLEACCESS'))) {
            return NULL;
        }
        $alisaname = $TYPE . "_ALISANAME";

        $this->_db->reset()->table($this->$alisaname);
        $values = array();
        foreach ($newValue as $field => $value) {
            $values[] = $value;
            $this->_db->Fields($field);
        }
        $this->_db->Record($values);
        if (!empty($cond)) {
            $where = array();
            foreach ($cond as $key => $value) {
                $where[] = $key . "='" . $value . "'";
            }
            $this->_db->Where(implode(' and ', $where));
        }
        $result = $this->_db->Update();
        return $result['status'];
    }
}