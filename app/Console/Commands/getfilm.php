<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Console\Command;

class getfilm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:film';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'recuperer les film (puis apres on verra pour le save dans la bdd)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
