<?php


$content = 'HTTP/1.1 200 OK
Connection: close
Content-Type: text/plain
Set-Cookie: wxuin=2460137520; Domain=wx.qq.com; Path=/; Expires=Sat, 22-Apr-2017 18:29:04 GMT
Set-Cookie: wxsid=ie/1f66Oxv5UpbOh; Domain=wx.qq.com; Path=/; Expires=Sat, 22-Apr-2017 18:29:04 GMT
Set-Cookie: wxloadtime=1492842544; Domain=wx.qq.com; Path=/; Expires=Sat, 22-Apr-2017 18:29:04 GMT
Set-Cookie: mm_lang=zh_CN; Domain=wx.qq.com; Path=/; Expires=Sat, 22-Apr-2017 18:29:04 GMT
Set-Cookie: webwx_data_ticket=gSdpeEBIrWniuFzIQainX0nE; Domain=.qq.com; Path=/; Expires=Sat, 22-Apr-2017 18:29:04 GMT
Set-Cookie: webwxuvid=0b959c8f1f8af0465ba5964b947128095b2376d6f8fff7924798962f8e5a9d6e4e0a1a89b34ff3c9b79e23a60ab4d63d; Domain=wx.qq.com; Path=/; Expires=Tue, 20-Apr-2027 06:29:04 GMT
Set-Cookie: webwx_auth_ticket=CIsBELHt99cCGoABVf1iO0U7JumB0q54di2dMkWRUL53O5mliskgHmY7s/+KKjXUN8qqaLWe3bWAqps115Ud5eeJfKb/FwEbTzP2PlF/5dsBT3CKiJ1adyrHJTlPZ8X4DB4hETkbt3IeCnOsAHTcvYYTd5/HPEn/8Eqh5MsqENWHwOGHrpBEqW/zXd4=; Domain=wx.qq.com; Path=/; Expires=Tue, 20-Apr-2027 06:29:04 GMT
Content-Length: 286

<error><ret>0</ret><message></message><skey>@crypt_bac2c1e5_b960267a9a77b6012ec6207e195297a4</skey><wxsid>ie/1f66Oxv5UpbOh</wxsid><wxuin>2460137520</wxuin><pass_ticket>6UEuW2072oqy%2Bk%2FFCUErTDXRlTdGglClbpTlV2pQjVDa1IDx997UDfX2CA4Rf7AN</pass_ticket><isgrayscale>1</isgrayscale></error>';


preg_match('/wxuin=(.*);/iU',$content,$uin); 
preg_match('/wxsid=(.*);/iU',$content,$sid);
preg_match('/webwx_data_ticket=(.*);/iU',$content,$webwx);
preg_match('/<pass_ticket>(.*?)<\/pass_ticket>/', $content,$pass_ticket);
//语音消息
$msg = '&lt;msg&gt;&lt;voicemsg endflag="1" cancelflag="0" forwardflag="0" voiceformat="4" voicelength="960" length="1589" bufid="144967399864926778" clientmsgid="49c8fde84869f0a8256811b2a2d695c0filehelper156_1493005062" fromusername="bboywisdom" /&gt;&lt;/msg&gt;';
//视频消息
$msg = '&lt;?xml version="1.0"?&gt;<br/>&lt;msg&gt;<br/>	&lt;videomsg aeskey="33343031326433666531633863333264" cdnthumbaeskey="33343031326433666531633863333264" cdnvideourl="30680201000461305f0201000204547053ed02032df98a020412355a70020458fc79fc043d617570766964656f5f326330333536633566343435336164385f313439323934313331305f3137353531303233303431373934366538613431383836310201000201000400" cdnthumburl="30680201000461305f0201000204547053ed02032df98a020412355a70020458fc79fc043d617570766964656f5f326330333536633566343435336164385f313439323934313331305f3137353531303233303431373934366538613431383836310201000201000400" length="1764021" playlength="24" cdnthumblength="10447" cdnthumbwidth="365" cdnthumbheight="640" fromusername="KuN590815" md5="a110aae58f1aa4c292198e49a39d78da" newmd5="3f2160e6874a2760ac6dd0c4b0136740" isad="0" /&gt;<br/>&lt;/msg&gt;<br/>';


print_r($pass_ticket);