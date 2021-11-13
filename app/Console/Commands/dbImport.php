<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\IRCController;
use App\Http\Controllers\ImageController;

use App\Http\Controllers\IMDBController;
use App\ImageRepository;

use App\Movie;
use App\Upload;
use DB;

class dbImport extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'command:dbImport';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
      parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $i = 0;
    $total = 0;
    $uploads = Upload::where("id", ">=", 1)->get();
    foreach($uploads as $upload) {
      $i++;
      if($i < 3150) continue;
      echo "Iteration:". $i."\n";
      DB::table('uploads')->where('id', "!=", $upload->id)->where("ident_id", "=", $upload->ident_id)->delete();
      
    }



    die();
  		$i = 0;
  		$colors = IRCController::colors();
  		/* Parse JSON Database File */
      $path = "/var/www/harsh/public/allmovies.json";
      if (!\File::exists($path)) {
          throw new Exception("Invalid File");
      }
      $json = json_decode(\File::get($path)); // string)

      foreach($json as $row) {  
        $i++;
        if(!$row->IsSeries || $i < 4809) continue;
        
        $movie = Movie::where("title", $row->Title)->first();
        if(!$movie) {
        	$found = false;
	       	/* Insert Movie Record */
	        $movie = new Movie;
	        $movie->title = $title = $row->Title;
	        $movie->country = implode("/", $row->Countries);
	        $movie->director = implode("/", $row->Directors);
	        $movie->plot = $row->PlotSummary;
	        $movie->poster = $row->PosterImageLink;
	        $movie->rating = $row->IMDbRating;
	        $movie->seasons = "n/A";
	        $movie->runtime = $row->Duration;
	        $movie->trailer_link = $row->TrailerLink;
	        $movie->year = intval($row->ReleasedYear);
	        $movie->release_date = "1991-01-01 00:00:00";
          $exp = explode("-", $row->Title);
          if($row->IsSeries) $movie->seasons = end($exp);
	        $movie->save(); 

	        $imdb = new IMDBController;
	        $data = new \stdClass();

		      /* Insert Cast & Characters into DB */
		      $data->theActors = implode(",", $row->Actors);
		      $imdb->insertCast($data, $movie); 

		      /* Loop Plot Keywords & Insert into DB */
		      $explode = explode(",", $row->Tags);
		      foreach($explode as $tag) $tags[] = $tag;
		      $data->keywords = implode("/", $tags);
		      //$imdb->insertTags($data, $movie); 

		      /* Loop Genre & Insert into DB */
		      $data->theGenres = implode(",", $row->Genres);
		      $imdb->insertGenre($data, $movie); 

        } else {
        	$found = "[Existing]";
        }

        //echo $title."\n";
        if($row->IsSeries) {
          IRCController::alert($colors["green"].'[import]'.$colors["nc"].' #'.$i.' '.$row->Title. '(TV) '.$found, "#pre");
        } else { 
          	IRCController::alert($colors["green"].'[import]'.$colors["nc"].' #'.$i.' '.$row->Title. ' (Movie) '.$found, "#pre");
        }

        /* Loop Uploads for this entry */
        foreach($row->FilmEps as $upload) {
        	$subs = Array();
        	foreach($upload->Subtitles as $subtitle) {
        		$subs[$subtitle->Language] = $subtitle->SubLink;
        	}

        	foreach($upload->Links as $link) {
        		if(!strstr($link->Link, "https://drive.google.com/file/d/")) continue;
        		$explode = explode("https://drive.google.com/file/d/", $link->Link);
        		$end = end($explode);
        		$driveId = str_replace("/preview", "", $end);
		        $upload2 = new Upload;
		        $upload2->ident_id = $driveId;
		        $upload2->server_id = $link->ServerId;;
		        $upload2->imdb_id = $movie->id;
		        $upload2->episode_title = "";
		        $upload2->episode_num = 0;
		        $upload2->views = 0;
            if(isset($upload->Title)) $upload2->episode_title = $upload->Title;
            if(isset($upload->EpisodeIndex)) $upload2->episode_num = $upload->EpisodeIndex;

		        $upload2->upload_percent = 0;
		        $upload2->subtitle_json = json_encode($subs);
		        $upload2->referral_url = "";
        		$upload2->size_bytes = 0; //get_size($data->theUrl);
        		$upload2->quality = $row->Quality;
		        $upload2->save();
        	}
      	}

      	/* Download cover photo */
        $image = ImageController::downloadFromUrlToCDN($row->PosterImageLink, 'poster_'.$movie->id.'.jpg');
        if($image) {
            $movie->poster_image_id = $image->id;
            $movie->save();
        }

        echo $movie->title."\n";

        /* Get remote file size 
        $upload->size_bytes = get_size($data->theUrl); */

        //if($i > 10) break;
      }

  }
}


/**
 * Returns the size of a file without downloading it, or -1 if the file
 * size could not be determined.
 *
 * @param $url - The location of the remote file to download. Cannot
 * be null or empty.
 *
 * @return The size of the file referenced by $url, or -1 if the size
 * could not be determined.
 */
function get_size( $url ) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $data = curl_exec($ch);
  curl_close($ch);
  $length = explode("Content-Length:", $data);
  $length = str_replace("\n", " ", end($length));
  $length = explode(" ", $length)[1];

  return $length;
}