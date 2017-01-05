
<?php
$appid = 'wx1640e8d62ab97a4f';
$secret = '96340a19b9b00523acbca2205254d752';
//请求腾讯接口 获取token 测试号每天2000次
// 获取access_token地址
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
// 获取access_token文件信息
$fileCon = file_get_contents("saemc://access_token.txt");
$fileJson = json_decode($fileCon);

// 判断access_token是否过期
if ($fileJson->time<time()-7000) {
	// 通过接口重新获取access_token
	$str = file_get_contents($url);
$json = json_decode($str);//把json字符串转为json对象

$access_token = $json->access_token;

$data = array("access_token"=>$access_token,"time"=>time());
$json_str = json_encode($data);

// 保存获取到的access_token
file_put_contents("saemc://access_token.txt", $json_str);
}else{
	$access_token = $fileJson->access_token;
}

// echo $access_token;

//获取用户列表

$url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}";
$list = file_get_contents($url);
$listObj = json_decode($list);
// var_dump($listObj);
// exit();

//循环输出用户列表
$arr = $listObj->data->openid;
for($i = 0; $i <count($arr);$i ++){
	// 用户openID
	$openid = $arr[$i];
	// 获取用户信息地址
$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
//获取接口信息
$user = file_get_contents($url);
// echo $user;
// 把获取的信息转为json对象
$obj = json_decode($user);
// 输出表格显示获取到的信息
echo "<table>";
echo "<tr>
      <td><img style='width:60px' src='{$obj->headimgurl}'</td>
      <td>{$obj->nickname}</td>
      <td>".($obj->sex==1?"男":"女")."</td>
      <td>{$obj->city}</td>
     </tr>";
echo "</table>";
}



// // 用户openID
// $openid = 'oND2_weNL4-afa31eSPSWAByT2T0';
// // 获取用户信息地址
// $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
// //获取接口信息
// $user = file_get_contents($url);
// // echo $user;
// // 把获取的信息转为json对象
// $obj = json_decode($user);
// // 输出表格显示获取到的信息
// echo "<table>";
// echo "<tr>
//       <td><img style='width:60px' src='{$obj->headimgurl}'</td>
//       <td>{$obj->nickname}</td>
//       <td>".($obj->sex==1?"男":"女")."</td>
//       <td>{$obj->city}</td>
//      </tr>";
// echo "</table>";

 ?>