<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time:2018/7/31 0:34
// +----------------------------------------------------------------------
// | TITLE: 生成订单号
// +----------------------------------------------------------------------

namespace App\Helper\Snowflake;


class Snowflake
{

    const debug = 1;


    static $sequence = 0;


    const workerIdBits = 5;
    const dataCenterId = 5;
    static $maxWorkerId = 31;
    static $maxDataCenterId = 31;

    static $timestampLeftShift = 22;
    private static $lastTimestamp = -1;

    static $dataCenterIdShift = 17;
    static $dataCenterId;

    static $workerIdShift = 12;
    static $workerId;

    static $sequenceMask = 255;
    static $sequenceMaskShift = 4;
    static $userID = null;


    protected $tableID = null;


    /**
     * @var null
     */
    private static $self = NULL;

    /**
     * @param $userID
     * @param int $dataCenterId
     * @return Snowflake|null
     * @throws \Exception
     */
    public static function getInstance($userID, $dataCenterId = 1)
    {
        if (self::$self == NULL) {
            self::$self = new self($userID, $dataCenterId);
        }
        return self::$self;
    }

    function __construct($userID, $dataCenterId = 1)
    {
        $workId = (int)(getmypid() % self::$maxWorkerId);
        if ($workId > self::$maxWorkerId || $workId < 0) {
            throw new \Exception("worker Id can't be greater than 15 or less than 0");
        }
        if ($dataCenterId > self::$maxWorkerId || $workId < 0) {
            throw new \Exception("worker Id can't be greater than 15 or less than 0");
        }
        if ($userID == null) {
            throw new \Exception("worker Id can't be greater than 15 or less than 0");
        }
        self::$workerId = $workId;
        self::$dataCenterId = $dataCenterId;
        self::$userID = $userID;

        $this->tableID = sprintf("%02d", (($userID % 16) + 1));
    }

    function timeGen()
    {
        //获得当前时间戳
        $time = explode(' ', microtime());
        $time2 = substr($time[0], 2, 3);
        return $time[1] . $time2;
    }

    private function tilNextMillis($lastTimestamp)
    {
        $timestamp = $this->timeGen();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = $this->timeGen();
        }
        return $timestamp;
    }

    function nextId($userID = null)
    {
        if ($userID != null) {
            self::$userID = $userID;
            $this->tableID = sprintf("%02d", (($userID % 16) + 1));
        }
        $timestamp = $this->timeGen();
        if (self::$lastTimestamp == $timestamp) {
            self::$sequence = (self::$sequence + 1) & self::$sequenceMask;
            if (self::$sequence == 0) {
                $timestamp = $this->tilNextMillis(self::$lastTimestamp);
            }
        } else {
            self::$sequence = 0;
        }
        if ($timestamp < self::$lastTimestamp) {
            throw new \Exception("Clock moved backwards.  Refusing to generate id for " . (self::$lastTimestamp - $timestamp) . " milliseconds");
        }
        self::$lastTimestamp = $timestamp;


        $nextId = ($timestamp << self::$timestampLeftShift) | (self::$dataCenterId << self::$dataCenterIdShift) | (self::$workerId << self::$workerIdShift) | (self::$sequence << self::$sequenceMaskShift);
        $nextId = decbin($nextId); //转换为二进制

        $timeStr = (string)bindec(substr($nextId, 0, (strlen($nextId) - self::$timestampLeftShift))); //转换为10进制

        $nextId = date('YmdHis', substr($timeStr, 0, 10)) // 14位
            . (string)$this->tableID  //2位
            . (string)sprintf("%05d", (bindec(substr($nextId, -self::$timestampLeftShift, 18)))) //8位
            . substr($timeStr, 10, 3); //3位
        return $nextId;
    }


}
