<?php

namespace app\api\library;
use think\Db;
use fast\Http;
/**
 * 支付公共类
 */
class Alipay
{
    
    public function BaoHuo($cookie,$id)
    {
        $beat = $this->AlipayBaohuo($cookie,'',$id);
        $userInfo = $this->getAliInfo('',$beat,'',$id);
        if(empty($userInfo['data']['userId']))
        {
            Db::name('qrlist')->where('id', $id)->update(['status'=>0,'updatetime'=>time()]);
		}
		else
		{
		    Db::name('qrlist')->where('id', $id)->update(['zfb_pid'=>$userInfo['data']['userId'],'updatetime'=>time()]);
		}
        return $userInfo['data']['userId'];
    }
    
    /****************保活Alipay账号***************/
    public  function AlipayBaohuo($Cookie = null,$proxy='',$id='')
    {
        $ress = $this->httpRequest2('https://my.alipay.com/portal/i.htm?src=yy_taobao_gl_01&sign_from=3000&sign_account_no=&guide_q_control=top', array('Content-Type:application/x-www-form-urlencoded','cookie: '.$Cookie), [], 1, 1,1,$proxy,$id);
        if (preg_match_all('/Set-Cookie:(.*);/iU',$ress['header'],$strs))
        {
    		$cookiess=[];
    		foreach ($strs[1] as $k=>$v){
    			$arrs= explode("=", $v);
    			$cookiess[trim($arrs[0])] = $arrs[1];
    		}
    	}
    	$cookieArr = explode(";", $Cookie);
    	if(!empty($cookiess['ctoken'])) {
    		$cookieArr[0] = 'ctoken='.$cookiess['ctoken'];
    	}
    	if(!empty($cookiess['ALIPAYJSESSIONID']))
    	{
    		$cookieArr[1] = 'ALIPAYJSESSIONID='.$cookiess['ALIPAYJSESSIONID'];
    	}
    	if(!empty($cookiess['spanner']))
    	{
    		$cookieArr[2] = 'spanner='.$cookiess['spanner'];
    	}
        return empty($cookieArr[1]) ? $Cookie:$cookieArr[1];
    }
    /****************获取会员信息***************/
    public function getAliInfo($ctoken,$cookie,$proxy='',$id=''){
    	$url = 'https://mrchportalweb.alipay.com/interface/login/index/queryuser?_ksTS=&_input_charset=utf-8&ctoken='.$ctoken;
    	$aHeader = array(
    		'Content-Type:application/x-www-form-urlencoded',
    		'cookie:'.$cookie
    		);
    	$res = $this->httpRequest2($url, $aHeader, [], 1, 0,1,$proxy,$id);
    	$resArr = json_decode($res['html'],true);
    	if (!$resArr){
    		return false;
    	}
    	if (!empty($resArr['stat']) && $resArr['stat'] == 'deny'){
    		return false;
    	}
    	return $resArr;
    }

	//新获取余额接口
	public  function Get_Alipay_Money($Cookie,$pid)
	{
	    preg_match('/ctoken=(.*?);/', base64_decode($Cookie), $uin);
		$Url = 'https://mbillexprod.alipay.com/enterprise/accountTotalAssetQuery.json?ctoken='.$uin[1];
		$today = strtotime(date("Y-m-d"),time());
		$end = $today+60*60*24;
		$startDateInput=rawurlencode(date("Y-m-d H:i:s", $today));//获取5分钟之内的订单
        $endDateInput= rawurlencode(date("Y-m-d H:i:s",$end));
        $str='billUserId='.$pid.'&pageNum=1&pageSize=20&startTime='.$startDateInput.'&endTime='.$endDateInput.'&status=ALL&sortType=0&_input_charset=gbk';
		$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $Url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$str,
          CURLOPT_HTTPHEADER => array(
            'authority: mbillexprod.alipay.com',
            'sec-ch-ua: "Google Chrome";v="93", " Not;A Brand";v="99", "Chromium";v="93"',
            'accept: application/json, text/javascript, */*; q=0.01',
            'content-type: application/x-www-form-urlencoded; charset=UTF-8',
            'x-requested-with: XMLHttpRequest',
            'sec-ch-ua-mobile: ?0',
            'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Mobile Safari/537.36',
            'origin: https://mbillexprod.alipay.com',
            'sec-fetch-site: same-origin',
            'sec-fetch-mode: cors',
            'sec-fetch-dest: empty',
            'referer: https://mbillexprod.alipay.com/enterprise/accountTotalAssetQuery.htm',
            'accept-language: zh-CN,zh;q=0.9,en;q=0.8',
            'cookie: '.base64_decode($Cookie)
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $res=json_decode($response,true);
        return empty($res)?json_decode(mb_convert_encoding($response,'UTF-8','GBK'),true):$res;
	}
	protected  function getSubstr($str, $leftStr, $rightStr) {
        $left = strpos($str, $leftStr);
        $right = strpos($str, $rightStr, $left);
        if ($left < 0 or $right < $left) return '';
        return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
    }
	protected function alipayCurl($api,$cookie)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, 'https://business.alipay.com/user/home');
        curl_setopt($ch, CURLOPT_USERAGENT,
        "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $res;
    }
    /************获取⽀付宝账单请求*************/
    public function getAliOrder($cookie,$pid)
    {
        $startDateInput=rawurlencode(date("Y-m-d H:i:s", time()-(60*5)));//获取5分钟之内的订单
        $endDateInput= rawurlencode(date("Y-m-d H:i:s",strtotime('now')));
        preg_match('/ctoken=(.*?);/', base64_decode($cookie), $uin);
        $str='endDateInput='.$endDateInput.'0&precisionQueryKey=tradeNo&precisionQueryValue=&showType=1&startDateInput='.$startDateInput.'&billUserId='.$pid.'&pageNum=1&pageSize=100&startTime='.$startDateInput.'&endTime='.$endDateInput.'&status=1&queryEntrance=1&sortTarget=tradeTime&activeTargetSearchItem=tradeNo&accountType=&sortType=0&startAmount&endAmount&targetMainAccount&precisionValue&goodsTitle&total=0&_input_charset=gbk';
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://mbillexprod.alipay.com/enterprise/fundAccountDetail.json?ctoken='.$uin[1],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$str,
          CURLOPT_HTTPHEADER => array(
            'authority: mbillexprod.alipay.com',
            'sec-ch-ua: "Google Chrome";v="93", " Not;A Brand";v="99", "Chromium";v="93"',
            'accept: application/json, text/javascript, */*; q=0.01',
            'content-type: application/x-www-form-urlencoded; charset=UTF-8',
            'x-requested-with: XMLHttpRequest',
            'sec-ch-ua-mobile: ?0',
            'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Mobile Safari/537.36',
            'origin: https://mbillexprod.alipay.com',
            'sec-fetch-site: same-origin',
            'sec-fetch-mode: cors',
            'sec-fetch-dest: empty',
            'referer: https://business.alipay.com/user/mbillexprod/account/detail',
            'accept-language: zh-CN,zh;q=0.9,en;q=0.8',
            'cookie: '.base64_decode($cookie)
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $res=json_decode($response,true);
        return empty($res)?json_decode(mb_convert_encoding($response,'UTF-8','GBK'),true):$res;
    }
    public static function httpRequest2($sUrl, $aHeader, $aData, $https = 1, $echoHeader = 0,$daili=0,$proxy1='',$id='')
    {
        $cookiefile = "ck/".$id."_cookie.txt"; // 创建一个用于存放cookie信息的临时文件,也是最关键的一个
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $sUrl);
        if ($aHeader) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
        if ($aData) {
            curl_setopt($ch, CURLOPT_POST, true);
            if (is_array($aData)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aData));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $aData);
            }
        }
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_HEADER, $echoHeader);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile); // 关闭连接时，将服务器端返回的cookie保存在以下文件中
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
        $sResult = curl_exec($ch);
        if ($sError = curl_error($ch)) {
            die($sError);
        }
        $res = [];
        $res['html'] =$sResult;
		$res['info'] = curl_getinfo($ch);
        if ($echoHeader) {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            // 根据头大小去获取头信息内容
            $header = substr($sResult, 0, $headerSize);
            $res['header']=$header;
            $res['html']=substr($sResult, $headerSize, mb_strlen($sResult));
        }
        curl_close($ch);
        return $res;
    }
    
    

    
}
