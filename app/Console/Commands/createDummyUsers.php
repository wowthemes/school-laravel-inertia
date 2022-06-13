<?php

namespace App\Console\Commands;

use App\Models\Attachment;
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
        // $attachment = Attachment::factory()->create([
        //     'user_id'   => 1,
        // ]);
        // dd($attachment);
        $totalCreateUser = $this->argument('count');

        for ($i = 0; $i < $totalCreateUser; $i++) { 
            if( $i % 2 ) {
                $user = User::factory()->create();
            } else {
                $user = User::factory()->unverified()->create();
            }
            $attachment = Attachment::factory()->create([
                'user_id'   => $user->id,
            ]);
            $user->attachments()->sync([$attachment->id]);
        }
    }
}
