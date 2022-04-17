<?php
class qq_qrlogin{
	public function getqrcode(){
		//获取验证码地址
		$url = 'https://ssl.ptlogin2.tenpay.com/ptqrshow?appid=546000248&e=2&l=M&s=3&d=72&v=4&t=0.4080289'.time().'&daid=120&pt_3rd_aid=0';
		//请求资源
		$result = $this->get_curl($url,0,'https://xui.ptlogin2.tenpay.com/',0,0,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',0,1);
		preg_match('/qrsig=(.*?);/',$result['header'],$qrsig);
		if($qrsig[1] != ''){
			exit('{"code":1,"messgae":"OK","qrsig":"'.$qrsig[1].'","data":"'.base64_encode($result['body']).'"}');
		}else{
			exit('{"code":-1,"messgae":"二维码获取失败"}');
		}
	}

	public function qrlogin($qrsig = 0){
		if($qrsig == null || $qrsig == '') return exit('{"code":-1,"messgae":"qrsig不能为空"}');
		$url = 'https://ssl.ptlogin2.tenpay.com/ptqrlogin?u1=https%3A%2F%2Fwww.tenpay.com%2Fv2%2Fres%2Fjs%2Fyui%2Fbuild%2Flogin%2Fptlogin.shtml&ptqrtoken='.$this->getqrtoken($qrsig).'&ptredirect=0&h=1&t=1&g=1&from_ui=1&ptlang=2052&action=0-0-'.time().rand(111,999).'&js_ver=21050810&js_type=1&login_sig='.$qrsig.'&pt_uistyle=34&aid=546000248&daid=120&';
		$result = $this->get_curl($url,0,'https://xui.ptlogin2.tenpay.com/','qrsig='.$qrsig.';',0,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',0,1);
	    //取二维码状态
		preg_match("/ptuiCB\(\'(.*?)\'\,/",$result['body'],$state);
		$state = $state[1];
		switch($state){
			case '0':
				//登录成功
				//echo $result['header']."\n".$result['body'];
				//取出CK 
				$ck = $this->getcookie($result['header']);
				preg_match('/\'https:(.*?)\'/',$result['body'],$u2);
				$u2 = 'https:'.$u2[1];
				//准备继续取CK
				$ret = $this->get_curl($u2,0,'https://xui.ptlogin2.tenpay.com/',$ck,0,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',0,1);
				$ck2 = $this->getcookie($ret['header']);
				//组合新的CK
				$ck = $ck.$ck2;
				exit('{"code":1,"message":"OK","cookie":"'.base64_encode($ck).'"}');
				break;
			case '65':
				//二维码过期
				exit('{"code":-1,"message":"timeout"}');
				break;
			case '66':
				//等待扫描
				exit('{"code":-1,"message":"waiting"}');
				break;
			case '67':
				//正在验证
				exit('{"code":-1,"message":"scanned"}');
				break;
			default:
			exit('{"code":-1,"message":"error"}');
		}
	}


	private function getcookie($head=0){
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

	private function getqrtoken($qrsig){
        $len = strlen($qrsig);
        $hash = 0;
        for($i = 0; $i < $len; $i++){
            $hash += (($hash << 5) & 2147483647) + ord($qrsig[$i]) & 2147483647;
			$hash &= 2147483647;
        }
        return $hash & 2147483647;
    }

	private function get_curl($url,$post=0,$referer=0,$cookie=0,$httpheaders = 0,$header=0,$ua=0,$nobaody=0,$split=0){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$httpheader[] = "Accept: application/json";
		$httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
		$httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
		$httpheader[] = "Connection: close";
		if($httpheaders){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);
		}else{
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
		}
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
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36');
		}
		if($nobaody){
			curl_setopt($ch, CURLOPT_NOBODY,1);

		}
		$ip_long = array(
			array('607649792', '608174079'),
			array('1038614528', '1039007743'),
			array('1783627776', '1784676351'),
			array('2035023872', '2035154943'),
			array('2078801920', '2079064063'),
			array('-1950089216', '-1948778497'),
			array('-1425539072', '-1425014785'),
			array('-1236271104', '-1235419137'),
			array('-770113536', '-768606209'),
			array('-569376768', '-564133889'),
			);
		$rand_key = mt_rand(0, 9);
		$ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip));
		curl_setopt($ch, CURLOPT_ENCODING, "gzip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
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
}


$login=new qq_qrlogin();
$do = $_GET['do'];
if($do == 'getqrpic'){
	$login->getqrcode();
}
if($do == 'qrlogin'){
$login->qrlogin($_GET['qrsig']);
}

?>