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

class deleteDupe extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'command:deleteDupe {--ident_id= : The ID of the user} {--keep_id= : The ID of the user}';

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
    
    $ident_id = $this->option('ident_id');
    $keep_id = $this->option('keep_id');
    DB::table('uploads')->where('id', "!=", $keep_id)->where("ident_id", "=", $ident_id)->delete();

  }
}
