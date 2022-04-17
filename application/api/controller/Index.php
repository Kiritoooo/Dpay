<?php

namespace app\api\controller;
use think\Db;
use app\common\controller\Api;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $url = $this->postsubmit();
     
        return mb_convert_encoding($url,'UTF-8','GBK');
        

       // $this->success($url);
    }
    
    //Post地址
    //https://excashier.alipay.com/standard/edeposit30001/templateFlow.htm?orderId=b30db0efd4704b2ba9ae564edc94d3e2&method=securitypost
    //参数：_form_token  viewModelId accountBalanceUrl depositBankLimitUrl channelType  channelAccessType  
    //instId apiCode  accountNo jsonUa  accountHidden payeeUserId defaultBank  amount  remark 
    
    
    
    //json ua 写死：ve0CcozeJGTLVDA2q8W7mF9WjZ8koPHVMWjKypl90KRk8Cceu89dOn0mLt1RYjO3qrsUmjTXz4qQmzTsUwrtEfBM3fVW4gCKLl7XObXu3pt2OlQiL5348jRCpTVgwfpl9S2o9Grst.MLcmXwRkzkcPE830fXeirXKy0n6b8BJXZKymFPaI9tNOO9ZzqP0J7amAP.IO065jZvOY66gVX3UxQmzuuTz5c3eJeFpUzalFH1Niyhe7h3KRHkMp8IvKsuS7njyrnfGsXRW1P0ex4nqdF8HR3yQzBVJAi5LtCanc4MjVmnnJgTxCXidASiup4md4E2CQNA_gKemPHd..cTVbN6CJ_Zp9fwDhVTn_Xt7IhallL1EKCWoBY549J1WSQP8a8Nx7HbgjWwNDkxTCRdgsMCGx7TGahWWPyhhhqwfpQxQssl3aQuQx.0FckPG06kVNiqr3DGcAMKnrRAUlMpKrOzQCTzJKMl2.ad4vEJ1TCtSCgUlKFVX8hCF1gvjipw8UGwqiBbP_s_DxMFgdbhmZg8v882aoOCBHlfpL_kQIdn8uOMNrztrldYCVehR4bWXLLJSbLxKWnlSlWqNHvPKodnb8MwLcgjwdoy6kr.I2BCGde2Cr0Wdx73Eyx.ZPLlJvb0QyXp5nAJO5fKw3l3hRQi_g4JviEhsNBGtnpAdO4lt_Myh8ii0ZLOQWzNFJDKEV59Hv4PgB2tfIfTo_tQql12Dc2YNWz8HM8Y4howMkXq.xIB3Rb6HIFfkZ9DhRAkY8fkZsOVs5gPJjfxLTZYnlhjrJw.YP2UnQVfyVHOky5a3uKb8wFSMCAbRpidEhrZX45T3XXW9CRpw7hU1cNyS1_0m4kd_NgPSKE.8rwYxAIo3RtuOninSpR_QlJQAg3MnxriMUhg3t5GJJGz9MvZ5Ut6P2BP4RJC5Z.g06jTcvq2atDefWdgTI8zr.19uEF.dmiupeU2KHjmzOc77p5qbeTnr_qva_QZezLQfxkaO62oHBARxM4OVjEAWqgGsOSlC5F65IkALX0knM0JLtz.nLEHguBI6VncA3Dl8Hf2ADAsuhNs6_5HpTgZDu83RTRyLALeHJMwRZkk4bjYUIxJsxy2bauri7k6VaLjf1XC5ntzQqGC5.neDAhvW9ljypsQHRZD7Bf3nKhaUok33uLvKTwJPVdy7BddDg3AQLm0S62DXG0Yp05QlYj4GHUFqbqZ_Nek_ZZ1jSvgFAKE5LalAOF7syLMwTw29Q0z6C9dxztgrbLzhNZIW3jlVSE94krjgFzdHoLg8Qw4fcyY800UNffakDk8YxUMDIIKTL1Bf.fDVAP0v53UTOwGAwKfA1xp
    
    
    
    /***************获取充值的URL******************/
    function getorderid()
    {
        $cookie = 'csrfToken=u4RZUOJOsvnIlN2CtW1Yrweq; tree=a1911%01e5d5900f-abc9-40ae-b266-d6fc5d8c2c89%011; cna=/5dJGiiQoEICARvRAuOPl/lk; ctoken=MMm6NJSON__wXUv8; ALIPAYJSESSIONID=RZ41si5qzllINTUb9KJvTgTityDyDjauthRZ55GZ00; UM_distinctid=17de0684c9812c-02dbdf2e1c6e6a-3e604809-1fa400-17de0684c99285; spanner=3troAtxDK0xR4gOG7sVwzbcnmhVc/yPW; rtk=TkHrojWSlOD1/7t9KkA06gjxgqdrAqrFaqT2CttjPsbEAq9aqp4; l=eBxss0w7gZXUf8MkBO5aFurza77toIRbzsPzaNbMiInca1rF5F6nbOCpglIvOdtjgtfAletPkdi_7RFekzaT5jDDBeYCIWtukxv9O; tfstk=cEqCBeMZhBAQZmbyYJ6wLivSbYHAaBvjFwG3dzh8vVnFtpwI6sxW0jMLYzA8Qbk1.; isg=BDIyUG-6h48yGruzhmsFBFoug3gUwzZdpa4s2PwL1uXQj9CJ5FU3b6unfysz_671';
        $url = 'https://bizfundprod.alipay.com/allocation/deposit/index.htm?depositType=onlineBank';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_REFERER, 'https://mrchportalweb.alipay.com/');
        curl_setopt($ch, CURLOPT_USERAGENT,
        "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
        // 下面两行为不验证证书和 HOST，建议在此前判断 URL 是否是 HTTPS
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt ($ch, CURLOPT_COOKIE, $cookie);
        // $ret 返回跳转信息
        $ret = curl_exec($ch);
        // $info 以 array 形式返回跳转信息
        $info = curl_getinfo($ch);
        // 跳转后的 URL 信息
        $retURL = $info['url'];
        // 记得关闭curl
        curl_close($ch);
        return $retURL;
    }
    
    
    function getorderid2()
    {
        $cookie = 'csrfToken=u4RZUOJOsvnIlN2CtW1Yrweq; tree=a1911%01e5d5900f-abc9-40ae-b266-d6fc5d8c2c89%011; cna=/5dJGiiQoEICARvRAuOPl/lk; ctoken=MMm6NJSON__wXUv8; ALIPAYJSESSIONID=RZ41si5qzllINTUb9KJvTgTityDyDjauthRZ55GZ00; UM_distinctid=17de0684c9812c-02dbdf2e1c6e6a-3e604809-1fa400-17de0684c99285; spanner=3troAtxDK0xR4gOG7sVwzbcnmhVc/yPW; rtk=TkHrojWSlOD1/7t9KkA06gjxgqdrAqrFaqT2CttjPsbEAq9aqp4; l=eBxss0w7gZXUf8MkBO5aFurza77toIRbzsPzaNbMiInca1rF5F6nbOCpglIvOdtjgtfAletPkdi_7RFekzaT5jDDBeYCIWtukxv9O; tfstk=cEqCBeMZhBAQZmbyYJ6wLivSbYHAaBvjFwG3dzh8vVnFtpwI6sxW0jMLYzA8Qbk1.; isg=BDIyUG-6h48yGruzhmsFBFoug3gUwzZdpa4s2PwL1uXQj9CJ5FU3b6unfysz_671';
        $url = 'https://excashier.alipay.com:443/standard/edeposit30001/templateFlow.htm?orderId=4f83d1c00b914b938219bbbb470cc37f&action=init';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_REFERER, 'https://mrchportalweb.alipay.com/');
        curl_setopt($ch, CURLOPT_USERAGENT,
        "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
        // 下面两行为不验证证书和 HOST，建议在此前判断 URL 是否是 HTTPS
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt ($ch, CURLOPT_COOKIE, $cookie);
        // $ret 返回跳转信息
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
    
    
    function postsubmit()
    {
        $cookie = 'csrfToken=u4RZUOJOsvnIlN2CtW1Yrweq; cna=/5dJGiiQoEICARvRAuOPl/lk; ctoken=MMm6NJSON__wXUv8; UM_distinctid=17de0684c9812c-02dbdf2e1c6e6a-3e604809-1fa400-17de0684c99285; l=eBxss0w7gZXUfJ4CBO5ZKurza77TCIOfGsPzaNbMiInca1rlSF6nbOCpgr7WtdtjgtfvEetPkdi_7REH7R438xsP1HHOIWtukzp64; isg=BIuL5U7ZbpC5XbLER6jcK0udGi91IJ-i1F1lD_2JDkohHK9-hfO_8xT09hzyPPea; tfstk=coPhB7DEeJkQurMgh6GQW3r-RDuPaAOrm7P__S83_DDT3Cii8s2wQKWgsNmHdIp5.; rtk=UR10TrCF4Dh0oLnxdR412MBYKG4d3hESG8U6pCnrpiZ548QX8vA; zone=RZ41B; ALIPAYJSESSIONID=RZ41si5qzllINTUb9KJvTgTityDyDjauthGZ00RZ41; spanner=LG9k2d2P4Ka9dPw58sM35DIfzOB4GzKKXt2T4qEYgj0=';
        $url = 'https://excashier.alipay.com/standard/edeposit30001/templateFlow.htm?orderId=4f83d1c00b914b938219bbbb470cc37f&method=securitypost';
        $str = '_form_token=8f5274a23d0040b2bda46c4552664581467ca19d6dbb48b09c64b0166ed9ab4dGZ00&viewModelId=sync%24depositFrontConfirmActionModel&accountBalanceUrl=https%3A%2F%2Fexcashier.alipay.com%3A443%2Fstandard%2Fedeposit30001%2FtemplateFlow.json%3ForderId%3D4f83d1c00b914b938219bbbb470cc37f%26templateName%3DetpDepositFront%26viewModelId%3Dsync%2524async_enterpriseBalanceViewModel%26asyncRequest.sign%3DMCwCFAToYqdMQ%252B0He88KszkZeQyr%252Bn3pAhQj0lNhZvB6cpP27p1%252FgAsOGDe67A%253D%253D&depositBankLimitUrl=https%3A%2F%2Fexcashier.alipay.com%3A443%2Fstandard%2Fedeposit30001%2FtemplateFlow.phtm%3ForderId%3D4f83d1c00b914b938219bbbb470cc37f%26templateName%3DetpDepositFront%26viewModelId%3Dsync%2524async_depositBankLimitViewModel%26asyncRequest.sign%3DMCwCFDqxnsW%252B29SnpqZWIGIWRQsdK6MiAhRwLyDUEed0xAU%252FEBGw6xeGX7%252FcqQ%253D%253D&channelType=B2C_EBANK&channelAccessType=EBANK_B2C&instId=ABC&apiCode=abc101&accountNo=2088041916006731&jsonUa=htLoCBONF0V.ocZ4iGX5myT1qZ9avkTO5jUf6iJRGquHVSeiognQjp8O8lOBz1R1E5BXD9SdfB1f2kVlqiFfbsscWNJNggBuTFed.2ho_JLsVTc4xo36GZvT18PdZQUwsMYgh8cGyNBk6Jn3onH4AuP7k_rS0wrbnlU5OIB1mtXFAor.Sr9gRWB3Tp7mZi6YUEFwYBId5RtR2Pmpklnz3.TUoQyCRlbYtU7R5mqGgBhCgsDYKdbslvcF6hYbQKCD_VgKTdRgiL3tJcbUP9GwmAQ_CeERzyLHgMNmCWNDqdU1vM2hHdNueU_Y0S7aW7ej.DZPK6.3_kf1yZtmlMxF_0LrDGYOX.xUbtJMGvO_GfCAAo10ESes6NcxV4Biuk6R3cCubLazs96pI_SAVwz73dYF2Y.uUVWwyDqtoNKUBDvst4S_RP.BBNB2dLpd5SVZ3dgAIYRMpEIgi7RzLTJ9lo6asTUr._VDbaTSdaxdssVbnnjKjdH4Zr3L7WU7tmfgfy6yubMLKgeshCR6cTC4WK7UlrbPEP2QiohdGoOGQej.OgIPFYtXggZCiuhf5wDgveI54MOqEZzMp1n6cNHpJ057_2XXvLuWJzMSCBbxptEuErTfJXHNEB4MrArCI2IKRm8WdhaYkda0odal3fDC2r0lk3WU0yT22wUlqbMoma34j8WigGQTq.AW7HNF3G4ZhR6QBDhn2K9fpfmiLn1nwWnRGqzNj0BS0Hoeb9ShVool26mSrM0G59Dj1LUkrLIrw5.xYqDoo6U9hE74U2wLzrvSezVf4dn8AayzNYxDhcGDsa5F94ygTN9kHLd0ltFV9vDdrU7dLBs7IH_Wz.Z2QUuf0yPfR63g.3iN3.vVK4QFzIPWgSKkHMxkXjPQU5M2Rmt4US5FtHMzs0SBcnn3CwdQ6kYeX1JbUjw0EM4Mah5I23ZC_dqB2VselWLXBJdKFeFQuOygkNu1aMhUGBuGwvWL3e3wMEW_XifJGfSOhzTAyC_9GD5IqOFmZVyYHwx18wF804jMW4EoKVl1CpDYLf1WRU0G8Y3_WftWUYyBeAAr20Fakf.P5EZ.hBR5NFEsb0fyHG.WDBrt0bSFzefqxv34ZaDrmpFCvsM5ofc5DThMycBM16BhnVqYxnwbEA_TICqldmWJ6pd_RqvnRDvCNhZSInYu.5nrOaUieaFJQ0z70hOwqmk4q5PK6nbZYgpBFD2X5FIuUgCawwu_evsIlHfU7UyR_AANN.a3c0V3ySi23IxpE5qtL7T2PoSlWjzxjVEac7SxjeRX1y9ItoaWMTIJ8RmffQyMKzZB5xWvf8seUZnZOK7RrOtZlUA0jhs0Ajf6MmFv54tg6NbGTtsP_fVCFKr8ABGmZ738Q16mUpurNlLHLTqTpXJCCAcqiG2uJ1EwPJsfhOBxy.v6RDnGRbNS_kuNVucK09thoSIXH1SGNrnzad.nw7y9WL5t_oJHs8i8kqLnGTIbF142bjKrJo8MVsaEf_L2YagdKKKft8lC3Lvo__bAqCwzIjsN0zjY1rgIdVbw0YOy1mLh7bZxVfYERlUT7i24mHidZlXaZpr5Y1Cq59GO7Wv1xN8lfAtmQZZQrVmC7b4vqmrtTnZRnAfUi9CJnadEPO_YCQytG5v_mTYRUiQc3GqQxB9LgbEjkXdit_vVeKcRW3lkTv6cre9moKHqXXS9U4gR42eiaAu5iDrp2amI0e41mHDaiZR903gUEkFHJDn0peM6qvkNTBz8X35D4oT1HeTZt8HS5ua_QolP1JHtDSL.LEiLtyrXPt_9BwfSJzNYHOSfHSwRM2ESQ0KV44YUTDcEaGNn_8LzHlmljKHwEmQxTlE8oQWCLhcWX4dQXbRS.c3NvXC7fC&accountHidden=2088041916006731&payeeUserId=2088041916006731&defaultBank=abc101&amount=1.00';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
        curl_setopt($ch, CURLOPT_USERAGENT,
        "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
        // 下面两行为不验证证书和 HOST，建议在此前判断 URL 是否是 HTTPS
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        // $ret 返回跳转信息
        $ret = curl_exec($ch);
        // $info 以 array 形式返回跳转信息
        $info = curl_getinfo($ch);
        // 跳转后的 URL 信息
        $retURL = $info['url'];
        // 记得关闭curl
        curl_close($ch);
        return $ret;
    }
    
    
    
    
    
}
