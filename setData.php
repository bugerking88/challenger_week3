<?php
header("content-type: text/html; charset=utf-8");
require_once("PDOConnect.php");
error_reporting(E_ALL & ~E_NOTICE);
ignore_user_abort();
set_time_limit(0);
$interval=60;
$mc = new Memcached();
$mc->addServer("localhost", 11211);
class setData extends PDOConnect
{
    function getDataList()
    {
        $sql = "SELECT * FROM `RecordTable`";
        $getData = $this->db->prepare($sql);
        $getData->execute();
        $result = $getData->fetchAll();
        return $result;
    }
}

$setDateMem = new setData();
$result=$setDateMem->getDataList();
do{
    $setDateMem->getDataList();
    $mc->set("foo", $result);
    sleep($interval);// 等待60s
}while(true);
// $mc->set("foo", $result);

