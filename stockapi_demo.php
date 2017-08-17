<?php

$url = 'http://test.stockapi.nicaifu.com/api.php';

date_default_timezone_set('PRC');  //设置中国的时区
function get_millisecond()  
{   //php没有原生的毫秒时间戳,这是通过秒级时间戳和微秒处理出来的
	$time = explode (".", microtime (true) );   
	$time = (float)($time [0] * 1000) . "." . $time [1];
	return $time;
}
//必须参数项
$appkey = 'test_app_key'; //appkey
$secret = 'password';		// 与appkey对应的secret
$user = '13900009704'; 		//appkey下的注册手机号
$t = get_millisecond() ;   //取一个时间戳
//业务参数处理
$bisParams = array();
$bisParams['action'] = 'brief'; //查资产和持仓信息
//$bisParams['product_code'] = '601633.SS'; //业务参数中赋值股票代码

//Post 参数处理
$post= compact('appkey','user','t');
$post = array_merge($post,$bisParams);// 合并必须参数和业务的参数
ksort($post); //按键升序排列参数
//计算签名
$valuestr = '';
foreach($post as $k => $v)
{
	$valuestr = $valuestr . $v;  //把值串连接起来成为一个字符串
}
$post['s'] = md5($valuestr . $secret);
// 初始化一个 cURL 对象 
$curl = curl_init(); 
// 设置你需要抓取的URL 
curl_setopt($curl, CURLOPT_URL, $url); 
// 1如果成功只将结果返回，不自动输出任何内容。如果失败返回FALSE 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
//设置post参数字段
curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
// 运行cURL，请求网页 
$data = curl_exec($curl); 
// 关闭URL请求 
curl_close($curl); 
// 显示获得的数据 
print_r($data); 
?>
