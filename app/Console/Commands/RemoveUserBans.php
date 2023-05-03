<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RemoveUserBans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:bans:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove banned user ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('banned_until', '<', now())->get();

        foreach ($users as $user) {
            $user->banned_until = null;
            $user->save();
        }
    }
}
