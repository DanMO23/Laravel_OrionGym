<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateAdmin extends Command
{
    protected $signature = 'create:admin {name} {email} {password}';
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
        
        $user->assignRole('admin');
        

        $this->info('Admin created successfully with ID: ' . $user->id);
    }
}
