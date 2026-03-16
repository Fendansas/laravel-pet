<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanExports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-exports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = glob(storage_path('app/items_*.zip'));

        foreach($files as $file){

            if(filemtime($file) < now()->subDay()->timestamp){
                unlink($file);
            }

        }
    }
}
