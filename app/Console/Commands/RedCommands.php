<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RedCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'red:tongji';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto tong ji kouke';

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
        echo "Start Auto tong ji kouke ...\n";
        app('drc')->gxtjall(2);
        echo "End Auto tong ji kouke ...";
    }
}
