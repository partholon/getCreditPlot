<?php
/**
 * File:index.php
 * Description:简陋的输入首页
 * Create By:Partholon
 * Create Date:2015-8-23
 */

function getImg($content){
	include('./simple_html_dom.php');
	$html = new simple_html_dom();
	$html->load($content);
	foreach( $html->find('.ide_code_image') as $img){
		$img->src = "http://cas.nwpu.edu.cn/cas/".$img->src;
		return $img->src;
	}
}

//构造HTTP请求头
$n2 = rand(202, 239);
$n3 = rand(1, 254);
$n4 = rand(1, 254);
$ip = "42." . $n2 . "." . $n3 . "." . $n4;
$header = array(
    "Host:cas.nwpu.edu.cn",
    "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "Accept-Encoding:gzip, deflate, sdch",
    "Accept-Language:zh-CN,zh;q=0.8,en;q=0.6",
    "Connection:keep-alive",
    "User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.155 Safari/537.36",
    "CLIENT-IP:$ip",
    "X-FORWARDED-FOR:$ip");

//获取Cookie
$cookie = tempnam("./temp", "cookie");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://cas.nwpu.edu.cn/cas/login?service=http%3A%2F%2Fportal.nwpu.edu.cn%2Fdcp%2Findex.jsp");
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
$content = curl_exec($ch);
curl_close($ch);

$src = getImg($content);
$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
	<title>学分绩测试</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />
	<script src=\"js/js.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
</head>
<body>
	<div id=\"main\">
		<p>学号：<input type=\"text\" name=\"user\" value=\"2013301930\" /></p>
		<p>密码：<input type=\"password\" name=\"pwd\" value=\"OIERZZ.\" /></p>
		<p>验证码：<input type=\"text\" name\"capt\" value=\"\"><img src=\"$src\" alt=\"卧槽没找到\" /></p>
		<input type=\"hidden\" value=\"$cookie\" />
		<button type=\"button\" onclick=\"getGrade()\" >
		获取学分绩</button>
	</div>
</body>
</html>";

echo $html;
