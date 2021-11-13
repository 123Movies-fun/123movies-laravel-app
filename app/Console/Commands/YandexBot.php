<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MovieDownloaderController;

class YandexBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:YandexBot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue up 3 more uploads for yandex bot.';

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
        $downloader = new MovieDownloaderController;
        $downloader->YandexBot();
    }
}
