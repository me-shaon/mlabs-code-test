<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateNewUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-new-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new dummy user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::factory()->create();
    }
}
