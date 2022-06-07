<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class createDummyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create faker users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $totalCreateUser = $this->argument('count');

        for ($i = 0; $i < $totalCreateUser; $i++) { 
            if( $i % 2 ) {
                User::factory()->create();
            } else {
                User::factory()->unverified()->create();
            }
        }
    }
}
