<?php
function getcookie($head=0){
if(empty($head)){
return false;
}
$preg = '/Set-Cookie:\ (.*?);/';//获取
preg_match_all($preg,$head,$view);
$v = $view[1];
for($i=0;$i<count($v);$i++){
$string .= $v[$i].';';
}
return $string;
}
function get_curl($url,$post=0,$referer=0,$cookie=0,$header=0,$ua=0,$nobaody=0,$split=0){
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$httpheader[] = "Accept:*/*";
		$httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
		$httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
		$httpheader[] = "Connection:close";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
		if($post){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		if($header){
			curl_setopt($ch, CURLOPT_HEADER, TRUE);
		}
		if($cookie){
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		if($referer){
			curl_setopt($ch, CURLOPT_REFERER, $referer);
		}
		if($ua){
			curl_setopt($ch, CURLOPT_USERAGENT,$ua);
		}else{
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');
		}
		if($nobaody){
			curl_setopt($ch, CURLOPT_NOBODY,1);

		}
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		$ret = curl_exec($ch);
		if ($split) {
			$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$header = substr($ret, 0, $headerSize);
			$body = substr($ret, $headerSize);
			$ret=array();
			$ret['header']=$header;
			$ret['body']=$body;
		}
		curl_close($ch);
		return $ret;
	}

function getSubstr($str, $leftStr, $rightStr)
{
$left = strpos($str, $leftStr);
//echo '左边:'.$left;
$right = strpos($str, $rightStr,$left);
//echo '<br>右边:'.$right;
if($left < 0 or $right < $left) return '';
return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");
    return str_replace($qian, '', $str);   
}
        $act = $_GET['act'];
        if($act == "getqrcode"){
	    $code = get_curl("https://auth.alipay.com/login/index.htm?goto=https%3A%2F%2Fconsumeprod.alipay.com%2Frecord%2Fstandard.htm",0,"https://shanghu.alipay.com/i.htm",0,1,"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36");
	    $cookie = getcookie($code);
		$qrCodeSecurityId = getSubstr(trimall($code),'qrCodeSecurityId"value="','"/>');
        $rds_form_token = getSubstr(trimall($code),'<inputtype="hidden"name="errorGoto"value=""/><inputtype="hidden"value="','"name="rds_form_token"/>');
        $passwordSecurityId = getSubstr(trimall($code),'passwordSecurityId"value="','"/>');
        $alieditUid = getSubstr(trimall($code),'<inputtype="hidden"id="alieditUid"name="alieditUid"value="','"/>');
        $preCheckTimes = getSubstr(trimall($code),'name="preCheckTimes"value="','"/><span');
        $qrcode = str_replace("|","%257C",$qrCodeSecurityId);
        $qrcode = "https://qr.alipay.com/_d?_b=PAI_LOGIN_DY&amp;securityId=".$qrcode;
          get_curl("https://seccliprod.alipay.com/api/do.htm?serviceId=webmlog&data=".base64_encode('{"products":"singlePassword","id":"'.$passwordSecurityId.'","edit_serverPolicy_render":"R","edit_serverPolicy_sensor":"","edit_serverPolicy_tolerate":true,"edit_serverPolicy_upgrade":false,"edit_serverPolicy_downloadPath":"","edit_browserPolicy_render":"R","edit_browserPolicy_sensor":"-1"}'),0,'https://auth.alipay.com/login/index.htm?goto=https%3A%2F%2Fconsumeprod.alipay.com%2Frecord%2Fstandard.htm',0,0,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36');
          get_curl("https://seccliprod.alipay.com/api/do.htm?serviceId=webmlog&data=".base64_encode('{"edit_getCi1":-1,"id":"'.$passwordSecurityId.'","edit_getCi2":-1,"edit_getNetInfo":-1}'),0,"https://auth.alipay.com/login/index.htm?goto=https%3A%2F%2Fconsumeprod.alipay.com%2Frecord%2Fstandard.htm",0,0,"User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36");
          $loginid = mt_rand(111111,999999);
            
          $save = [
          	"cookie" => base64_encode($cookie),
          	"qrCodeSecurityId" => base64_encode($qrCodeSecurityId),
          	"rds_form_token" => base64_encode($rds_form_token),
          	"passwordSecurityId" => base64_encode($passwordSecurityId),
          	"preCheckTimes" => base64_encode($preCheckTimes),
          ];

           $json = json_encode($save);
           file_put_contents("./ck/".$loginid.".txt",$json);
          $return = [
           "code" => 1,
           "msg" => "获取成功",
           "loginid" => $loginid,
           "qrcodeurl" => urlencode($qrcode)
          ];
          exit(json_encode($return));
      }
      if($act == "getcookie"){
       $id = $_GET["loginid"];
       if(empty($id)){
          $return = [
           "code" => -1,
           "msg" => "loginid不能为空",
          ];
          exit(json_encode($return));
       }
       $txt = "./ck/".$id.".txt";
       if(is_file($txt)==false){

          $return = [
           "code" => -1,
           "msg" => "loginid不存在，请重新获取二维码",
          ];
          exit(json_encode($return));
       }
      function param($param){
      	global $id;
       $json = file_get_contents("./ck/".$id.".txt");
       $json = json_decode($json,true);
      	return base64_decode($json[$param]);
      }

      $txt = get_curl("https://securitycore.alipay.com/barcode/barcodeProcessStatus.json?securityId=".str_replace("|","%7C",param("qrCodeSecurityId"))."&_callback=light.request._callbacks.callback1",0,"https://auth.alipay.com/login/index.htm?goto=https%3A%2F%2Fconsumeprod.alipay.com%2Frecord%2Fstandard.htm",param("cookie"),0,"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36");
 
      if(strstr($txt,"waiting")){
      	$return = [
           "code" => -1,
           "msg" => "二维码还未扫描",
           "stat" => "waiting"
          ];
          exit(json_encode($return));
      }

      if(strstr($txt,"scanned")){
      	$return = [
           "code" => -1,
           "msg" => "二维码还已扫描但未确认",
           "stat" => "scanned"
          ];
          exit(json_encode($return));
      }

      if(strstr($txt,"confirmed")){
      	$post = "support=000001&needTransfer=&CtrlVersion=1%2C1%2C0%2C1&loginScene=index&redirectType=&personalLoginError=&goto=https%3A%2F%2Fconsumeprod.alipay.com%2Frecord%2Fstandard.htm&errorVM=&sso_hid=&site=&errorGoto=&rds_form_token=".param("rds_form_token")."&json_tk=&method=qrCodeLogin&logonId=&superSwitch=true&noActiveX=false&passwordSecurityId=".str_replace("|","%7C",param("passwordSecurityId"))."&qrCodeSecurityId=".str_replace("|","%7C",param("qrCodeSecurityId"))."&password_input=&password_rsainput=&J_aliedit_using=true&password=&J_aliedit_key_hidn=password&J_aliedit_uid_hidn=alieditUid&alieditUid=".param("alieditUid")."&REMOTE_PCID_NAME=_seaside_gogo_pcid&_seaside_gogo_pcid=&_seaside_gogo_=&_seaside_gogo_p=&J_aliedit_prod_type=&security_activeX_enabled=false&J_aliedit_net_info=&checkCode=&idPrefix=&preCheckTimes=".param("preCheckTimes")."ua=";
      	$info = get_curl("https://authgtj.alipay.com/login/index.htm",$post,"https://auth.alipay.com/login/index.htm?goto=https%3A%2F%2Fconsumeprod.alipay.com%2Frecord%2Fstandard.htm",param("cookie"),1,"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36");
                 $cookies = getcookie($info);
                 
                 if($cookies)
                 {
                  //保存cookie到数据库
                  $return = [
                   "code" => 1,
                   "msg" => "获取成功",
                   "cookie" => base64_encode($cookies),
                  ];
                  unlink("./ck/".$id.".txt");
                  exit(json_encode($return));
                 }
      }

 $return = [
           "code" => -1,
           "msg" => "未知的异常",
          ];
          exit(json_encode($return));

      }
            $return = [
           "code" => -1,
           "msg" => "No act!",
          ];
          exit(json_encode($return));
?>