<!DOCTYPE html>
<html>
	<meta charset="UTF-8">
	<title>web chat</title>
	<link href="static/chat.css" rel='stylesheet' type='text/css' />
	<script src="static/jquery-1.7.2.js"></script>
</head>
<style>
 

/*a  upload */
.a-upload {
    padding: 4px 10px;
    height: 20px;
    line-height: 20px;
    position: relative;
    cursor: pointer;
    color: #888;
    background: #fafafa;
    border: 1px solid #ddd;
    border-radius: 4px;
    overflow: hidden;
    display: inline-block;
    *display: inline;
    *zoom: 1
}

.a-upload  input {
    position: absolute;
    font-size: 100px;
    right: 0;
    top: 0;
    opacity: 0;
    filter: alpha(opacity=0);
    cursor: pointer
}

.a-upload:hover {
    color: #444;
    background: #eee;
    border-color: #ccc;
    text-decoration: none
}
    
</style>
<body>

<div id="chat">
    <div class="sidebar">
        <div class="m-card">
            <footer>
                <input class="search" placeholder="查找好友">
            </footer>
        </div>
        <div class="m-list" style="overflow-y: scroll;height: calc(100% - 10pc);">
        	<ul>
        	</ul>
        </div>
    </div>
    <div class="main">
    <h3 align='center' class="to-user" username=""></h3>
        <div class="m-message">
            <ul>
                
            </ul>
        </div>
        <!--send-->
        <div class="m-text">
            <form id="uploadForm" enctype="multipart/form-data">
                <a href="javascript:;" class="a-upload"><input id="file" type="file" name="file" style="" />
                   点击这里上传文件
                </a>
            </form>
            <textarea placeholder="按 Ctrl + Enter 发送" class="input"></textarea>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    setInterval("synccheck()",30000);
    function synccheck(){
       var synckey = sessionStorage.synckey;

       if(!synckey){
           return;
       }
       
        $.ajax({
            url : "index.php?act=synccheck",
            datatype:'json',
            type:'post',
            data : {synckey: synckey},
            success : function(data){
                console.log(data);
            }  
        });
    }
    
    
$(function(){
	if(navigator.userAgent.match(/(iPhone|iPod|Android|ios)/i)){
		alert('暂不支持移动端访问，请移步PC端！');
		return false;
	}
	var synckey = '';
	var mname = '';
	var mnickname = '';
	var myheadimg = '';
	//微信初始化
	$.ajax({
			url : "index.php?act=init",
			datatype : 'json',
			type : 'post',
			async : false,
			data : {},
			success : function(data){
				var res = JSON.parse(data);
				//将synckey存入本地缓存，后续步骤需要
                                 console.log(res.SyncKey);
                                synckey =  JSON.stringify(res.SyncKey);//json 串形式存入
                                sessionStorage.synckey = synckey;
                         

				muname = res.User.UserName;
				sessionStorage.username = muname;
				mnickname = res.User.NickName;
				sessionStorage.nickname = mnickname;
				myheadimg = 'index.php?act=avatar&uri=' + escape(res.User.HeadImgUrl);
				//登陆用户信息
				var ustr = '<header>'
                +'<img class="avatar" width="40" height="40" alt="Coffce" src="'+ myheadimg +'">'
                +'<p class="name">'+ res.User.NickName +'</p>'
	            +'</header>';
	            $(".m-card").prepend(ustr);
				//遍历初始化返回的好友和公众号
				var userlist = res.ContactList;	
				var str = '';
				for (var key in userlist) {
					var img = 'index.php?act=avatar&uri=' + escape(userlist[key].HeadImgUrl);
					str += '<li class="active" username="'+ userlist[key].UserName +'">'
	            		+'<img class="avatar" width="30" height="30"  src="'+ img +'" />'
	            		+'<p class="name">'+ userlist[key].NickName +'</p>'
	        			+'</li>';
				}
				//$(".m-list ul").append(str);
			    //滚动到底部
			    $(".m-message").scrollTop($('.m-message ul')[0].scrollHeight);
			},
			error : function(data){
				console.log(data);
			}
		});
	//初始化 结束
        
        $("#file").change(function(){
               var username = sessionStorage.username;
                var toUsername = $('.to-user').attr('username');
                if(toUsername == ''){
                        alert('发送人不能为空！');
                        return;
                }
               
                $.ajax({
                    url: 'index.php?act=uploadimg&username='+username+'&toUsername='+toUsername,
                    type: 'POST',
                    cache: false,
                    data: new FormData($('#uploadForm')[0]),
                    processData: false,
                    contentType: false
                }).done(function(res) {
                    var res = JSON.parse(res);
                    if(res.status != undefined && res.status =='1'){
                            var str = '<li>'
                                +'<p class="time"><span></span></p>'
                                +'<div class="main self">'
                                +'<img class="avatar" width="30" height="30" src="'+ myheadimg +'">'
                                +'<div class="nick">'+ sessionStorage.nickname +'</div>'
                                +'<div class="text">'+ '<img style=\'max-height:100px;max-width:100px;padding-top: 9px;\' src="'+res.file+'" />' +'</div>'
                                +'</div>'
                                        +'</li>';
                                                        $(".m-message ul").append(str);
                                                    //滚动到底部
                                                    $(".m-message").scrollTop($('.m-message ul')[0].scrollHeight);
                                                }
                    
                    
                }).fail(function(res) {});
           
        });
        

	//获取所有好友列表
	$.ajax({
		url : "index.php?act=users",
		datatype : 'json',
		type : 'post',
		data : {},
		success : function(data){
			var res = JSON.parse(data);
			console.log(res);
			var users = {};//存储username =》 nickname
			//遍历初始化返回的好友和公众号
			var userlist = res.MemberList;	
			var str = '';
			for (var key in userlist) {
				var img = 'index.php?act=avatar&uri=' + escape(userlist[key].HeadImgUrl);
				var uname = userlist[key].UserName;
				var nickname = userlist[key].NickName;
				str += '<li class="active" username="'+ uname +'">'
                                +'<img class="avatar" width="30" height="30"  src="'+img+'" />'
                                +'<p class="name">'+ nickname +'</p>'
                                        +'</li>';
                                users[uname] = nickname;
                                
              
			}
			//把登陆用户的信息也附加上
			users[muname] = mnickname;

			sessionStorage.users = JSON.stringify(users);
			$(".m-list ul").append(str);
		    //滚动到底部
		    //$(".m-message").scrollTop($('.m-message ul')[0].scrollHeight);
		},
		error : function(data){
			console.log(data);
		}
		});
	//获取好友列表结束


	//var sync = setInterval("syncWx()",1000);
        
 
	sync();
	function sync(){
		//syncWx = function (){
		//同步服务器信息，轮训查询是否有新消息等
		if(!synckey){
			synckey = sessionStorage.synckey;
		}

		$.ajax({
			url : "index.php?act=sync",
			datatype : 'json',
			type : 'post',
			data : {synckey: synckey},
			success : function(data){
				var res = JSON.parse(data);
				//与服务器同步一次synckey就可能 不相同一次，所以每次同步完都将更新key
				//将synckey存入本地缓存，后续步骤需要
				synckey =  JSON.stringify(res.SyncKey);//json 串形式存入
				//sessionStorage.synckey = synckey;
				if(res.BaseResponse.Ret != 0){
					alert('与微信服务器通讯出错，请重新扫码登陆！');
					window.location.href='index.php';
				}else if (res.AddMsgCount) {
					console.log(res);
				
					var str = '';
					var messagelist = res.AddMsgList;
					var users = JSON.parse(sessionStorage.users);
					for (var key in messagelist) {
						//StatusNotifyCode=2 为通知消息
						if (messagelist[key].StatusNotifyCode == 0){
							var fname = messagelist[key].FromUserName;
                                                        var tureFromUserName = messagelist[key].tureFromUserName;
                                                        var nick = users[fname];
                                                        if(fname.indexOf('@@')>-1){
                                                            if( sessionStorage['g'+fname] == undefined){
                                                                    $.ajax({
                                                                           url:'index.php?act=webwxbatchgetcontact',
                                                                           datatype:'json',
                                                                           type:'post',
                                                                           async:false,
                                                                           data:{'fname':fname},
                                                                           success : function(res){
                                                                               console.log(res);
                                                                               sessionStorage['g'+fname] = res;
                                                                           }
                                                                    });
                                                            }
                                                            
                                                            console.log(sessionStorage['g'+fname]);
                                                            var groupinfo = JSON.parse(sessionStorage['g'+fname]);
                                                            var MemberList = groupinfo.ContactList[0].MemberList;
                                                            for(var i in MemberList){
                                                                console.log(MemberList[i]);
                                                                if(MemberList[i]['UserName']==tureFromUserName){
                                                                    fname = tureFromUserName;
                                                                    nick =  MemberList[i]['NickName'];
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                              
                                                            var uri = "/cgi-bin/mmwebwx-bin/webwxgeticon?seq=620940058&username="+ fname +"&skey=";
                                                            var userHeadimg = 'index.php?act=avatar&uri=' + escape(uri);
                                                                            str += '<li>'
                                                            +'<p class="time"><span></span></p>'
                                                            +'<div class="main">'
                                                            +'<img class="avatar" width="30" height="30" src="'+ userHeadimg +'">'
                                                            +'<div class="nick">'+ nick +'</div>'
                                                            +'<div class="text">'+ messagelist[key].Content +'</div>'
                                                            +'</div>'
                                                            +'</li>';
                                                    
  



						}
					}
					//for end
					$(".m-message ul").append(str);
				    //滚动到底部
				    $(".m-message").scrollTop($('.m-message ul')[0].scrollHeight);
				   
				}
				//通讯成功再轮询
				if (res.BaseResponse.Ret == 0){
				 sync();
				}
			},
			error : function(data){
			}
		})

	//}
	}
	

	//好友列表点击事件
	$(".m-list ul").on('click','li',function(){
		var username = $(this).attr('username');
		var nickname = $(this).children('p.name').text();
 		$('.to-user').attr('username',username);
 		$('.to-user').text(nickname);
	})
	//好友列表点击事件end

	//发送消息
	//发送消息
	$(".input").keypress(function(e) {
		//firefox enter code=13 ; chrome = 10		
		if (e.ctrlKey && (e.which == 13 || e.which == 10)){
			var text = $(".input").val();
			var toUsername = $('.to-user').attr('username');
			if(text == ''){
				alert('不能发送空内容！');
				return;
			}
			if(toUsername == ''){
				alert('点击左侧头像，选择聊天对象！');
				return;
			}

			$.ajax({
				url : "index.php?act=send",
				datatype : 'json',
				type : 'post',
				data : {
					toUsername:toUsername,
					content:text
				},
				success : function(data){
					var res = JSON.parse(data);
					
					if(res.BaseResponse.Ret == 0){
						var str = '<li>'
                    	+'<p class="time"><span></span></p>'
                    	+'<div class="main self">'
                        +'<img class="avatar" width="30" height="30" src="'+ myheadimg +'">'
                        +'<div class="nick">'+ sessionStorage.nickname +'</div>'
                        +'<div class="text">'+ text +'</div>'
                    	+'</div>'
	                	+'</li>';
						$(".m-message ul").append(str);
					    //滚动到底部
					    $(".m-message").scrollTop($('.m-message ul')[0].scrollHeight);
					}
					
				},
				error : function(data){
					console.log(data);
				}
			});
			//ws.send(content);
			$(".input").val('').focus();
		}
	});

	});

	</script>
</html>