<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DrcCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drc:initdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drc init database';

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
        echo "Now init database ...\n";
        $this->call('migrate:reset');
        $this->call('migrate');
        $this->call('db:seed');
    }
}
