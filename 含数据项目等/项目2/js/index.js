$(function (){
	
	init();
	function init(){
		$("#p1").show();
		//数钱榜
		touch.on(".ranking","tap",function(e){
			$("#ranking").show();
			$("#ranking").on("mousedown",function(e){
				e.preventDefault();
			});
		});
		//活动奖品
		touch.on(".prize","tap",function (){
			$("#prize").show();
		});
		//活动规则
		touch.on(".activity_rule","tap",function (){
			$("#activity_rule").show();
		});
		//使用说明
		touch.on(".shiyong","tap",function (){
			$("#shiyong").show();
		});
		//关闭弹窗
		$(".close").on("touchstart",function (){
			$(this).parent().hide();
		});
		//开始游戏
		touch.on(".start_btn","tap",function(e){
			//输入手机号和姓名
			$("#user_data").show();
			//提交用户信息
			$(".sub").on("touchstart",function(e){
				subSucc();//开始第二页
				e.preventDefault();
			})
		});
		function subSucc(){
			$("#p1").fadeOut();//第一页隐藏
			$("#p2").show();
			//上方字体切换
			var txtIndex = 0;
			var txtArr = ["img/p2_txt1.png","img/p2_txt2.png","img/p2_txt3.png"];
			var txtTimer = setInterval(function (){
				txtIndex++;
				if(txtIndex>txtArr.length-1){
					txtIndex = 0;
				}
				//切换字体图片
				$(".p2_txt").attr({
					src:txtArr[txtIndex]
				})
				
			},2000);
			//数钱
			var qianNum = 0;//钱数
			var downTimerBol = false;
			touch.on(".qian_wrap","touchstart",function(e){
					e.preventDefault();
			});
			touch.on(".qian_wrap","swipeup",function(e){
				$(".p2_shou").hide();
				qianNum++;
				downTimerBol = true;
				//钱数走之后立刻补上一张
				var qianObj = $("<img class='p2_qian_new' src='./img/p2_qian.jpeg'>");
				$(".qian_wrap").append(qianObj);
				
				qianObj.removeTimer = setTimeout(function (){
					qianObj.remove();
				},1000);
					
				var qianNumStr = String(qianNum);//将钱数转化成字符串
				//根据钱数来改变显示钱数的文本框time_num的值
				for(var i=0; i<qianNumStr.length; i++){
					//$(".time_num").size()表示.time_num元素的数量3，i=0时，eq(3-0-1)=eq(2);qianNumStr[qianNumStr.length-i-1]表示去字符串对应的单元，i=0时，html(qianNumStr[2]),则钱数显示框的个位数与钱数的个位实际对应
					$(".time_num").eq($(".time_num").size()-i-1).html(qianNumStr[qianNumStr.length-i-1]);
				}
				e.preventDefault();
			})		
			//数钱计时
			var downTimerNum = 60;		
			var timeDownTime = setInterval(function (){
				if(downTimerBol){
					downTimerNum--;
					//判断计时结束
					if(downTimerNum<0){
						clearInterval(timeDownTime);
						//切换画面
						$("#p2").hide();
						$("#p3").show();
						$("#result_num").html("￥"+qianNum);
						//利用随机数判断数钱的水平
						var resultTxt = Math.random()>0.5?"没办法！你已经强到没有对手了":"你太客气了，这不是你的挑战极限吧";
						$("#result_txt").html(resultTxt);
						//最高分与排名
						$("#highScore").html(977);
						$("#result_rank").html(66);
						//再来一次
						$(".p3_again").on("touchstart",function (){
							window.location.href="index.html";
						});
						//分享
						$(".p3_share_btn").on("touchstart",function (){
							$("#share").show();
							$("#share.p1_mask").on("touchstart",function (){
								$("#share").hide();
							});
						});
					}
					$(".clock").html(downTimerNum);//时钟
				}	
			},1000);			
		}
	}	
});