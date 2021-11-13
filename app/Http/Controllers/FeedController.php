<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use DB;
use auth;
use App\Link;
use App\Vote;
use App\CommunityLink;
use App\Community;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ArrayQuery;


class FeedController extends Controller
{
    
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('log', ['only' => ['fooAction', 'barAction']]);
        //$this->middleware('subscribed', ['except' => ['fooAction', 'barAction']]);
    }

    /**
        * View for main home page feed.
        *
        * @return Response
    */
    public function index($community = null)
    {
        if($community) $this->community = Community::where("name", "=", $community)->first();
        if(!isset($this->community) && $community) die("invalid community");

        $user = Auth::User();
        $items = $this->Links();
        $sorted = $this->SortItems($items);

        return view('feed.index', [
            "pageTitle" => isset($this->community->id) ? $this->community->name." - OpenPad.io" : "The Portal - OpenPad.io",
            "feedTitle"=>"<img src='https://cdn.discordapp.com/attachments/276521694582276096/289244484779245568/alien_bot_75.png' style='max-width: 35px;'> ".(isset($this->community->id) ? $this->community->name."" : "The Portal"), 
            "items"=>$sorted,
            "user" => $user
        ]);
    }
    
    /**
        * Grab Link Items for this Feed.
        *
        * @return Response
    */
    public function Links() {
        $user = Auth::User();

        $links = CommunityLink::OrderBy("created_at", "DESC");
        if(isset($this->community->id)) $links = $links->where("community_id", $this->community->id);
	$items = Array();

        $links = $links->get();
        foreach($links as $link) {
            $item = $link->link;
            $item->communityLink = $link;
            if($item->type == "link")  {
                $commentLink = "/link/".$item->id."/".($item->title);
                $link = $item->url;
                $item->icon = "http://www.google.com/s2/u/0/favicons?domain_url=".urlencode($item->url);
            }

            $parse_url = parse_url($item->url); 
            $item->hostname = str_replace("www.", "", $parse_url["host"]); 

            if($item->image) $cover_image = $item->image;
                else $cover_image = "/images/phoca_thumb_l_no_image.gif\"";

            $totalComments = 0;

            /* Vote Arrow Class Presets (already voted on item?) */   
            $existing_vote = false;
            if($user) 
                $existing_vote = Vote::where([
                    ["community_link_id", "=", $item->communityLink->id],
                    ["user_id", "=", $user->id]
                ])->first();           
            $item->up_color = "BBBBBB";
            $item->down_color = "BBBBBB";
            if(($existing_vote) && $existing_vote->value) {
                $item->up_color = "FF6600";
                $item->down_color = "BBBBBB";
            }
            if(($existing_vote) && !$existing_vote->value) {
                $item->up_color = "BBBBBB";
                $item->down_color = "3399FF";
            }

            /* Hotness Ranking Score */
            $dt = $item->communityLink->created_at;
            $ups = $item->communityLink->up_votes;
            $downs = $item->communityLink->down_votes;
            $item->score = VoteController::hotness($ups, $downs, $dt);

            $items[] = $item;
        }
        return $items;
    }
    
    /**
        * Grab Link Items for this Feed.
        *
        * @param  (obj) $items
        * @return Response
    */
    public function SortItems($items) {
	$arryQuery = Array();
        // Merge the arrays and order by date 
        if($items) $arryQuery = ArrayQuery::from($items)->orderDesc(function($item)
        {
            return $item->score;
        })->select();
        return $arryQuery;
    }
    
}
