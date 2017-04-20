<!doctype html>
<html>
<head>
  <meta charset="UTF-8"/>
  <meta name="description" content="WEB,微信机器人" />
  <meta name="keywords" content="微信机器人" />
  <title>微信网页版</title>
  <script type="text/javascript" src='static/jquery-1.7.2.js'></script>
</head>
<body>
  <h3 align="center">微信网页版</h3>
  <p align="center"><img src="<?php echo $qrcode; ?>" /></p>
  <p align="center" class="notice">请扫描二维码登录</p>
  <form action="index.php?act=cookies" method="post"><input type="hidden" name="url" value=""></form>
</body>
<script type="text/javascript">
//将用户uuid存入本地缓存
var uuid = "<?php echo $uuid; ?>";
sessionStorage.uuid = uuid;
 
getLoginStatus();
//var state = setInterval("getLoginStatus()",3000);
function getLoginStatus(){
  $.ajax({
	  url: 'index.php?act=status&uuid=' + uuid,
	  data: '',
	  dataType: 'json',
	  success: function(data){
	  		if(data.status == 1){
	  			getLoginStatus();
	  			$(".notice").html('扫描成功，请确认登录');
	  		}else if (data.status == 2) {
	  			//&fun=new&version=v2&lang=zh_CN 不加的话会返回1101错误代码
	  			$.post('index.php?act=cookies',{url:data.msg + '&fun=new&version=v2&lang=zh_CN'},function(res){
	  				console.log(res);
	  				if (res.status == 0){
	  					alert(res.msg);
	  				}else{
	  					//将用户wxuin,wxsid存入本地缓存
						var wxuin = res.uin;
						var wxsid = res.sid;
						sessionStorage.wxuin = wxuin;
						sessionStorage.wxsid = wxsid;
						//获取成功，跳转
						window.location.href = 'index.php?act=chat';
	  				}
	  				
	  			},'json')
	  			
	  		}else{
	  			$(".notice").html('请扫描二维码确认登录');
	  			getLoginStatus();
	  		}
	  },
	  error: function(data){
	  	getLoginStatus();
	  	console.log('获取登录状态错误');
	  }
  
})
}
</script>
</html>