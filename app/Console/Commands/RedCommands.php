<?php

namespace App\Console\Commands;

use App\Services\Drc\Drc;
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

    private $drc;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Drc $drc)
    {
        parent::__construct();
        $this->drc = $drc;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Auto tong ji kouke ...\n";
        $this->drc->sjtjKouke();
    }
}
