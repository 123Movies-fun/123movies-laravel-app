<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Defuse\Crypto\Crypto;

use App\Page;
use App\Image;
use App\Upload;

class Server extends Model
{
  public function sendMessageWCurlExec($api, $inputs, $async) {
  	  $server = $this;
      /* Send Data to our CloudBot server for processing */
      $data = new \stdClass();
      $data->api = $api;
      foreach($inputs as $key=>$val) $data->$key = $val;
      $message = json_encode($data);

      $key = $server->password;
      $key = \Defuse\Crypto\Key::loadFromAsciiSafeString($key);
      $ciphertext = \Defuse\Crypto\Crypto::Encrypt($message, $key);

      if(!isset($async) || $async == true) $async = " > /dev/null 2>/dev/null &";
      	else $async = "";

      exec("curl --data 'data=".$ciphertext."' http://".$this->ip."/api".$async, $data);
      $this->response = $data;
      
      return $this;
  }
  public function decryptPayload($payload) {
    $key = \Defuse\Crypto\Key::loadFromAsciiSafeString($this->password);
    $plaintext = \Defuse\Crypto\Crypto::Decrypt($payload, $key);
    return $plaintext;
  }

  public function Uploads() {
    return $this->hasMany("App\Upload");
  }
}
