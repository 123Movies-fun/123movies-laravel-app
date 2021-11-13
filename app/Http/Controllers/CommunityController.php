<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use DB;
use auth;
use App\Community;
use Redirect;

class CommunityController extends Controller
{
    
    public function __construct()
    {
        //$this->middleware('auth');

        $this->middleware('log', ['only' => ['fooAction', 'barAction']]);

        //$this->middleware('subscribed', ['except' => ['fooAction', 'barAction']]);
    }

    /**
        * Index view for community listing table.
        *
        * @param  Request $request
        * @return Response
    */
    public function getIndex()
    {
        $communities = DB::table('communities')->orderBy('id', 'desc')->paginate(15);
        
        return view("communities.list", ['communities'=>$communities]);
    }

    /**
        * View for creating a new community.
        *
        * @param  (int) $id
        * @return Response
    */
    public function getViewCommunity($id)
    {
        $communities = DB::table('communities')->where('id', $id)->first();
        return view('communities.viewPage', ["title"=>$communties->name, "id"=>$id, "page"=>$page]);
    }

    /**
        * View for creating a new community.
        *
        * @return Response
    */
    public function getCreate()
    {
        return view('communities.create');
    }
    
    /**
        * Process post request for create a new community.
        *
        * @param  Request $request
        * @return Response
    */
    public function postCreate(Request $request) {
        $user_id = Auth::id();
        $community = new Community;

        $data = $request->all();
        $validator = $community->validator($data);
        if($validator->fails()) {
            $errors = $validator->errors()->all();
            return Redirect::back()->withErrors($errors)->withInput();
        }

        $community->fill([
                'name' => $request->input('name'),
                'descr' => $request->input('descr'),
                'user_id' => $user_id
            ]);
        $community->save();
        
         return redirect('/c/list');
        
    }
    

    /**
        * Process post request for create a new community.
        *
        * @param  Request $request
        * @return Response
    */
    public function searchAPI(Request $request) {
        $output = Array();
        $results = \App\Community::where('name', "LIKE", "%".$request->input("phrase")."%")
                       ->orderBy('name', 'desc')
                       ->take(10)
                       ->get();

        foreach($results as $res) {
            $output[] = Array("name"=>$res->name, "icon"=>"http://easyautocomplete.com/images/sheroes/Black_Widow.png");
        }

        if(count($output)) return response()->json($output);
        
    }
    
}
