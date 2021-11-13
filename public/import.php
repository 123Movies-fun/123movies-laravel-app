<?php

error_reporting(0);

class GoogleLogin
{
    const SIGNIN_LOOKUP_URI = "https://accounts.google.com/_/signin/v1/lookup";
    const SIGNIN_password_URI = "https://accounts.google.com/signin/challenge/sl/password";
    const SERVICE_LOGIN_URI = "https://accounts.google.com/ServiceLogin?hl=vi&passive=true&continue=https://www.google.com.vn#identifier";

    private $accounts = [];
    private $account = 0;
    private $check = 0;

    function __construct($accounts='')
    {
        if(!$accounts)
        {
            $this->accounts = [ //gsuite account
                [
		    'email' => '',
                    'password' => '
                ]
            ];

        } else $this->accounts = $accounts;

        $this->account = rand(0,count($this->accounts)-1);
    }

    public function get($link)
    {
        {
            if($this->checkLogin())
            {
                $get = $this->curl('https://drive.google.com/file/d/'.$link.'/view?mobile=true', FALSE, $this->accounts[$this->account]['email']);
                $explode = explode(',["url_encoded_fmt_stream_map","', $get);

                if(isset($explode[1]))
                {
                    $explode = explode('"]', $explode[1]);

                    if(isset($explode[0]))
                    {
                        $datas = str_replace(['\u003d', '\u0026'], ['=', '&'], $explode[0]);

                        if(preg_match_all('/itag\=(.*)\&url\=(.*)\&quality/U', $datas, $streamMap))
                        {
							foreach ($streamMap[1] as $key => $itag)
							{
								if(in_array($itag, [18, 43, 59, 22, 37]))
								{
									$redirector = preg_replace(["/\/[^\/]+\.googlevideo\.com/", "/\/[^\/]+\.google\.com/"], "/redirector.googlevideo.com", 'url='.urldecode($streamMap[2][$key]));
									$redirector = preg_replace(["/\&app=texmex/", "/\/[^\/]+\.google\.com/"], "", $redirector);
										
									parse_str($redirector, $value);

									unset($value['quality']);
									unset($value['codecs']);
									unset($value['type']);
									$dataURL = $value['url'];
									unset($value['url']);

									$redirector = str_replace('"', "'", $dataURL.'&'.urldecode(http_build_query($value)));

									if($itag == '18') 
									{
										$tmp['type'] = "video/mp4";
										$tmp['label'] = 360;
										$tmp['file'] = $redirector;
										$data[] = $tmp;
									}
									if($itag == '59')
									{
										$tmp['type'] = "video/mp4";
										$tmp['label'] = 480;
										$tmp['file'] = $redirector;
										$data[] = $tmp;
									}
									if($itag == '22')
									{
										$tmp['type'] = "video/mp4";
										$tmp['label'] = 720;
										$tmp['file'] = $redirector;
										$data[] = $tmp;
									}
									if($itag == '37')
									{
										$tmp['type'] = "video/mp4";
										$tmp['label'] = 1080;
										$tmp['file'] = $redirector;
										$data[] = $tmp;
									}
								}
							}
                        }
                    }
                }
                return $data;
            }
        }
    }
	
	private function aasort (&$array, $key) {
		$sorter=array();
		$ret=array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		asort($sorter);
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		$array=$ret;
	}

    private function checkLogin()
    {
        $cookie = $this->accounts[$this->account]['email'];

        if(file_exists($cookie.'_'.md5($cookie).'.txt'))
        {
            $view_sources = $this->curl('https://myaccount.google.com', FALSE, $cookie);

            if(preg_match('/>'.$cookie.'</U', $view_sources))
            {
                return true;
            }
        }

        $login = $this->serviceLogin();

        if(preg_match('/>'.$this->accounts[$this->account]['email'].'</U', $login))
            return true;
        else
            return false;
    }

    private function serviceLogin()
    {
        $page = $GALX = $gxf = $continue = $hl = $_utf8 = $bgrespons = $pstMsg = $rmShown = '';

        $view_sources = $this->curl(self::SERVICE_LOGIN_URI, FALSE, $this->accounts[$this->account]['email']);

        if(preg_match('/<input name="Page" type="hidden" value="(.*)">/U', $view_sources, $page))
        $page = trim($page[1]);
        if(preg_match('/<input type="hidden" name="GALX" value="(.*)">/U', $view_sources, $GALX))
        $GALX = trim($GALX[1]);
        if(preg_match('/<input type="hidden" name="gxf" value="(.*)">/U', $view_sources, $gxf))
        $gxf = trim($gxf[1]);
        if(preg_match('/<input type="hidden" name="continue" value="(.*)">/U', $view_sources, $continue))
        $continue = trim($continue[1]);
        if(preg_match('/<input type="hidden" name="hl" value="(.*)">/U', $view_sources, $hl))
        $hl = trim($hl[1]);
        if(preg_match('/<input type="hidden" id="_utf8" name="_utf8" value="(.*)"\/>/U', $view_sources, $_utf8))
        $_utf8 = trim($_utf8[1]);
        if(preg_match('/<input type="hidden" name="bgresponse" id="bgresponse" value="(.*)">/U', $view_sources, $bgresponse))
        $bgresponse = trim($bgresponse[1]);
        if(preg_match('/<input type="hidden" id="pstMsg" name="pstMsg" value="(.*)">/U', $view_sources, $pstMsg))
        $pstMsg = trim($pstMsg[1]);
        if(preg_match('/<input type="hidden" name="rmShown" value="(.*)">/U', $view_sources, $rmShown))
        $rmShown = trim($rmShown[1]);

        $lookup = $this->curl(self::SIGNIN_LOOKUP_URI, [
            'Email' => $this->accounts[$this->account]['email'],
            'requestlocation' => self::SERVICE_LOGIN_URI,
            'bgresponse' => $bgresponse,
            'Page' => $page,
            'GALX' => $GALX,
            'gxf' => $gxf,
            'continue' => $continue,
            'hl' => $hl,
            'sacu' => 1,
            '_utf8' => $_utf8,
            'pstMsg' => $pstMsg,
            'checkConnection' => 'youtube:201:1',
            'checkedDomains' => 'youtube',
            'rmShown' => $rmShown
        ], $this->accounts[$this->account]['email']);

        $lookup = json_decode($lookup);

        if(isset($lookup->session_state))
        {
            $login = $this->curl(self::SIGNIN_password_URI, [
                'Page' => $page,
                'GALX' => $GALX,
                'gxf' => $gxf,
                'continue' => $continue,
                'hl' => $hl,
                'sacu' => '1',
                'ProfileInformation' => $lookup->encoded_profile_information,
                'SessionState' => $lookup->session_state,
                '_utf8' => $_utf8,
                'bgresponse' => $bgresponse,
                'pstMsg' => $pstMsg,
                'checkConnection' => 'youtube:201:1',
                'checkedDomains' => 'youtube',
                'identifiertoken' => '',
                'identifiertoken_audio' => '',
                'identifier-captcha-input' => '',
                'Email' => $lookup->email,
                'Passwd' => $this->accounts[$this->account]['password'],
                'PersistentCookie' => 'yes',
                'rmShown' => $rmShown
            ], $this->accounts[$this->account]['email']);

            return $login;
        }
    }

    private function curl($url, $datas='', $cookie='')
    {
        $ch = @curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if($cookie)
        {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie.'_'.md5($cookie).'.txt');
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie.'_'.md5($cookie).'.txt');
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($datas)
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas));
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
	
	private function encrypt($plaintext) 
	{
		$string = base64_encode($plaintext);
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'api.anyplayer.net';
		$secret_iv = 'Free proxyplayer forever';
		$key = hash('sha256', $secret_key); 
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
		return ($output);
	}

}

function splitid($url){
  if(preg_match("/file\/d\/([0-9a-zA-Z-_]+)\//", $url)){
    preg_match("/file\/d\/([0-9a-zA-Z-_]+)\//", $url, $mach);
    $gid = isset($mach[1]) ? $mach[1] : '';
  }
  else if(preg_match("/file\/d\/([0-9a-zA-Z-_]+)/", $url)){
    preg_match("/file\/d\/([0-9a-zA-Z-_]+)/", $url, $mach);
    $gid = isset($mach[1]) ? $mach[1] : '';
  }
  else if(preg_match("/id=([0-9a-zA-Z-_]+)/", $url)){
      preg_match("/id=([0-9a-zA-Z-_]+)/", $url, $mach);
      $gid = isset($mach[1]) ? $mach[1] : '';
  } else {
    $gid = $url;
  }

  return $gid;
}

function fetchValue($str, $find_start, $find_end){
	$start = stripos($str, $find_start);
	
	if($start==false) return '';
	$length = strlen($find_start);
	$end = stripos(substr($str, $start+$length), $find_end);
	return trim(substr($str, $start+$length, $end));
}

if(isset($_GET['v']) && $_GET['v'])
{

	$v = splitid($_GET['v']);

	$cache_active = (isset($_GET["nocache"])) ? false : true;
   	$cache_time = 4000;
   	$cache_path = 'cache/'.md5($v).'.cache';
	$cache_api = 'cache/'.md5($v).'_api_.cache';
	
    if($cache_active && file_exists($cache_path) && filesize($cache_path) >= 300 && (time() - filemtime($cache_path) < $cache_time)) {

		if (!empty($_GET["jwplayer"]) && $_GET["jwplayer"] === "true") {
			$data = @file_get_contents($cache_api);
			echo $data;
		} else {
			$data = @file_get_contents($cache_path);
			echo $data;
		}
	} else {
		
	    $login = new GoogleLogin();
		$getLink = $login->get($v);
		
		$sv = "andrew";
		$return["status"] = "ok";
		$return["apiserver"] = $sv;
		$return["docid"] = $v;
		$return["link"] = $getLink;
		
		if (!empty($_GET["jwplayer"]) && $_GET["jwplayer"] === "true") {
			echo json_encode($getLink,JSON_UNESCAPED_SLASHES);
		} else {
			echo json_encode($return,JSON_UNESCAPED_SLASHES);
		}

		if (strlen(json_encode($getLink,JSON_UNESCAPED_SLASHES)) > 300) {
			file_put_contents($cache_path, json_encode($return,JSON_UNESCAPED_SLASHES));
			file_put_contents($cache_api, json_encode($getLink,JSON_UNESCAPED_SLASHES));
		}
	}
	
}