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
print_r($webwx);exit;
