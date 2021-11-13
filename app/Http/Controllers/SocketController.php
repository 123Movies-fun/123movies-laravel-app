<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use LRedis;

class SocketController extends Controller {
	public function __construct()
	{
		$this->middleware('guest');
	}
	public function index()
	{
		return view('socket');
	}
	public function writemessage()
	{
		return view('writemessage');
	}
	public function sendMessage(){
		$redis = LRedis::connection();
/*LRedis::pipeline(function ($pipe) {
    for ($i = 0; $i < 10; $i++) {
        $pipe->publish('message', "woooh it works :)");
    }
});*/
		
		$redis->publish('message', "woooh it works :)");
		//return redirect('writemessage');
	}
}

