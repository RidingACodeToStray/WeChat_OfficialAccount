<?php 
//一获取授权code值
$code = $_GET["code"];
// echo "$code";
$appid = 'wx1640e8d62ab97a4f';
$secret = '96340a19b9b00523acbca2205254d752';
//二根据code值获取access_token
$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
$str = file_get_contents($url);
$json = json_decode($str);
// var_dump($json);
$access_token = $json->access_token;
// 用户openID
$openid = $json->openid;

//获取用户信息地址
$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

//获取接口信息
$user = file_get_contents($url);
//把获取的信息转为JSON对象
$obj = json_decode($user);

//输出表格显示获取到的信息
echo "<table>";
echo "<tr>
	<td><img style='width:50px' src='{$obj->headimgurl}' /></td>
	<td>{$obj->nickname}</td>
	<td>".($obj->sex==1?"男":"女")."</td>	
	<td>{$obj->city}</td>
</tr>";
echo "</table>"; 
?>