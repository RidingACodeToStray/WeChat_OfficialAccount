<?php
//外部引用

//二维码生成http://2.weixinbuild.applinzi.com/wx2_1/sample.php扫码访问

require_once "jssdk.php";
$jssdk = new JSSDK("wx1640e8d62ab97a4f", "96340a19b9b00523acbca2205254d752");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>

  <br>
  <br>
  <br>
  <button class="start"><h1>开始录音</h1></button>
  <button class="stop"><h1>停止录音</h1></button>
  <button class="play"><h1>播放</h1></button>


</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,//开启调试模式
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'onMenuShareAppMessage',
      'startRecord',
      'stopRecord',
      'playVoice',
    ]
  });
  wx.ready(function () {
    var start = document.querySelector(".start");
    var stop = document.querySelector(".stop");
    var play = document.querySelector(".play");
    var localId = null;//用于记录录音ID
    start.onclick = function(){
      wx.startRecord();
    };
    stop.onclick = function(){
      wx.stopRecord({
          success: function (res) {
            localId = res.localId;
          }
      });
    };
    play.onclick = function(){
      wx.playVoice({
          localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
      });
    };


    // 在这里调用 API
    wx.onMenuShareAppMessage({
      title: '微信测试', // 分享标题
      desc: '微信测试测试', // 分享描述
      link: 'http://baidu.com', // 分享链接
      imgUrl: 'http://www.dev666.com/dev666/static/images/dev666logo.png', // 分享图标
      type: '', // 分享类型,music、video或link，不填默认为link
      dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
      success: function () { 
          // 用户确认分享后执行的回调函数
      },
      cancel: function () { 
          // 用户取消分享后执行的回调函数
      }
    });
  });
</script>
</html>
