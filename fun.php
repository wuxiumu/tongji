<?php
// 当天有效时间范围
function checkIsBetweenTime($start, $end) {
    $date = date('H:i');
    $curTime = strtotime($date); //当前时分
    $assignTime1 = strtotime($start); //获得指定分钟时间戳，00:00
    $assignTime2 = strtotime($end); //获得指定分钟时间戳，01:00
    $result = 0;

    if ($curTime > $assignTime1 && $curTime < $assignTime2) {
        $result = 1;
    }

    return $result;
}
// 微信判断
function is_weixin_visit() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    } else {
        return false;
    }
}

// 手机判断
function wp_is_mobile() {
    static $is_mobile = null;

    if (isset($is_mobile)) {
        return $is_mobile;
    }

    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

/**
* 获取ip
* @return mixed
*/
function getIp() {
    $client_ip = '';
    if (isset($_SERVER)) {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            //优先使用  HTTP_X_FORWARDED_FOR，此值是一个逗号分割的多个IP
            //注意：我这里没做处理，是因为运维在入口处禁止了伪造请求头，HTTP_X_FORWARDED_FOR是可信的，不能代表所有业务场景
            //todo 没有禁止伪造请求头下的特殊处理
            $ipStr = $_SERVER["HTTP_X_FORWARDED_FOR"];
            $ipArr = explode(',', $ipStr);
            $client_ip = isset($ipArr[0])?$ipArr[0]:'';
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $client_ip = $_SERVER["HTTP_CLIENT_IP"];
        } else
        {
            $client_ip = $_SERVER["REMOTE_ADDR"];
        }
    }
    //过滤无效IP
    if (filter_var($client_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false || filter_var($client_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
        return $client_ip;
    } else {
        return $_SERVER["REMOTE_ADDR"];
    }
}
