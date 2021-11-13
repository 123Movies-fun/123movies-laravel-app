<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\ImageRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Movie;
use App\Server;

class ImageController extends Controller
{
    protected $image;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->image = $imageRepository;
    }


    public function getUpload()
    {
        return view('pages.upload');
    }

    /**
        * API / Post processing of image upload.
        *
        * @param  Request $request
        * @return Response
    */
    public function postUpload()
    {
        
        config(['images.full_size' => '/var/www/harsh/public/cdn/users/'.\Auth::User()->id.'/']);
        config(['images.icon_size' => '/var/www/harsh/public/cdn/users/'.\Auth::User()->id.'/thumbnails/']);
        File::makeDirectory('/var/www/harsh/public/cdn/users/'.\Auth::User()->id.'/', $mode = 0777, true, true);
        File::makeDirectory('/var/www/harsh/public/cdn/users/'.\Auth::User()->id.'/thumbnails/', $mode = 0777, true, true);

         
        $photo = Input::all();
        $response = $this->image->upload($photo);
        return $response;

    }

    /**
        * API / Post Processing for deleting an existing image.
        *
        * @param  Request $request
        * @return Response
    */
    public function deleteUpload()
    {

        $filename = Input::get('id');

        if(!$filename)
        {
            return 0;
        }

        $response = $this->image->delete( $filename );

        return $response;
    }


    /* Function for downloading an image with an available cloudbot for CDN hosting */
    static function downloadFromUrlToCDN($url, $filename) {
        $server = Server::find(2);
        $key = $server->password;
        $key = \Defuse\Crypto\Key::loadFromAsciiSafeString($key);

        /* Create new image in DB with status pending */
        $image = new Image;
        $image->filename = $filename;
        $image->location = "";
        $image->original_name = "";
        $image->type = "poster";
        $image->server_id = 2;
        $image->status = "pending";
        $image->save();

        /* Send Data to our CloudBot server for processing */
        $data = new \stdClass();
        $data->api = "image_download";
        $data->expires = time() + (60*3);
        $data->image_id = $image->id;
        $data->image_url = $url;
        $data->filename = $filename;
        $message = json_encode($data);

        $ciphertext = \Defuse\Crypto\Crypto::Encrypt($message, $key);
        $plaintext = \Defuse\Crypto\Crypto::Decrypt($ciphertext, $key);

        $res = exec("curl --data 'data=".$ciphertext."' http://".$server->ip."/api > /dev/null 2>/dev/null &");
        return $image;
    }
    public function CloudBotImageDLCompleted(Request $request) {
        $ip = $request->ip();;
        $image_id = $request->input("image_id");
        $image = Image::find($image_id);
        if(!$image) die("err");
        $image->status = "done";
        $image->location = $request->input("path");
        $image->save();
    }




    public function serverCDNUpgradeScript() {
        die();
        $images = [];
        $filesInFolder = \File::files('/var/www/harsh/public/cdn/posters');

        foreach($filesInFolder as $path)
        {

            $path = pathinfo($path);
            $movie = Movie::find((int) $path["filename"]);
            if($movie && $movie->poster_image_id == 0) {
                $image = new Image;
                $image->filename = $path["basename"];
                $image->location = $path["dirname"];
                $image->original_name = $path["basename"];
                $image->type = "poster";
                $image->server_id = 1;
                $image->save();

                $movie->poster_image_id = $image->id;
                $movie->save();
            }

        }
    }
}