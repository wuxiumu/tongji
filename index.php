<?php
include 'fun.php';
$redis = new redis();
$redis->connect('127.0.0.1', 6379);
$date = date("Y-m-d");
$ip = getIp();
$redis_name = $_GET['type']??'ad';
$num = $redis->incr($redis_name.':pv:total:key:date:'.$date);  
 
echo json_encode([
    'type'=>$redis_name, 
    'ip'=>$ip, 
    'date'=>$date,
    'num'=>$num
]);
