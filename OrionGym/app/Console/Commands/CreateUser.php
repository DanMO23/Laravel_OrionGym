<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
    protected $signature = 'create:user {name} {email} {password}';
    protected $description = 'Create a new user with a specified role';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        
        
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            
        ]);
        
        $user->assignRole('user');
        

        $this->info('User created successfully with ID: ' . $user->id);
    }
}
