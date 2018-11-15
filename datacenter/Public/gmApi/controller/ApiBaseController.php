<?php
require_once('MysqlDb.php');

class ApiBaseController {

    const KEY = 'is_a_test_key';

    public $response = array();

    public $responseData = '';

    public $time;

    public $sign;

    public $status;

    const STATUS_OK = 0;

    const STATUS_NO_DATA = 1;

    const STATUS_INVALID_TIME = -103;

    const STATUS_INVALID_SIGN = -103;

    const STATUS_INVALID_PARAMS = -101;

    const STATUS_SERVER_ERROR = -4;

    public function init() {
        $this->time = isset($_GET['time']) ? (int)$_GET['time'] : null;
        $this->sign = isset($_GET['sign']) ? $_GET['sign'] : null;
    }

    public function validate() {
        return $this->validateTime() && $this->validateSign();
    }

    public function validateTime() {
        if (empty($this->time) || abs(time() - $this->time) > 180) {//请求时间与当前时间差大于正负三分钟
            $this->setStatus(self::STATUS_INVALID_TIME, 'Invalid Time');
            return false;
        }
        return true;
    }

    public function validateSign() {
        if ($this->sign === null || $this->sign != md5('time=' . $this->time . '&key=' . self::KEY)) {
            $this->setStatus(self::STATUS_INVALID_SIGN, 'Invalid sign');
            return false;
        }
        return true;
    }

    public function sendResponse() {
        $this->response['Result'] = $this->status;
        $this->response['data'] = $this->responseData;
        try {
            $re = json_encode($this->response);
        } catch (Exception $e) {
            $re = json_encode(array('Result' => self::STATUS_SERVER_ERROR, 'data' => ''));
        }
        echo $re;
        exit(0);
    }

    public function run() {
        if (!$this->validate()) {
            $this->sendResponse();
        }
    }

    public function setStatus($code, $msg = 'OK') {
        $this->status = $code;
//        $this->status['code']=$code;
//        $this->status['msg']=$msg;
    }
}