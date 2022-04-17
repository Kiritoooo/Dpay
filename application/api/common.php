<?php
function curl2($url_array, $wait_usec = 0)
{
  if (!is_array($url_array))
  return false;
  $wait_usec = intval($wait_usec);
  $data  = array();
  $handle = array();
  $running = 0;
  $mh = curl_multi_init();
  $i = 0;
  foreach($url_array as $url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url['url']);
    
    if(!empty($url['headers'])){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $url['headers']);
    }
    if(!empty($url['post'])){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $url['post']);
    }

    if(!empty($url['header'])){
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
    }
    if(!empty($url['cookie'])){
        curl_setopt($ch, CURLOPT_COOKIE, $url['cookie']);
    }
    if(!empty($url['referer'])){
        if($url['referer']==1){
            curl_setopt($ch, CURLOPT_REFERER,$url['url']);
        }else{
            curl_setopt($ch, CURLOPT_REFERER, $url['referer']);
        }
    }
    if(!empty($url['ua'])){
        curl_setopt($ch, CURLOPT_USERAGENT,$url['ua']);
    }else{
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
    }
    if(!empty($url['ip'])){
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$url['ip'], 'CLIENT-IP:'.$url['ip']));
    }
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_NOBODY,0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 7);
   
    curl_multi_add_handle($mh, $ch);
    $handle[$i++] = $ch;
  }
  do {
    curl_multi_exec($mh, $running);
    if ($wait_usec > 0)
      usleep($wait_usec);
  } while ($running > 0);
  foreach($handle as $i => $ch) {
    $content = curl_multi_getcontent($ch);
    $data[$i] = (curl_errno($ch) == 0) ? $content : false;
  }
  foreach($handle as $ch) {
    curl_multi_remove_handle($mh, $ch);
  }
  curl_multi_close($mh);
  return $data;
}

?>
