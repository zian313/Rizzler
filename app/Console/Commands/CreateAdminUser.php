<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?? $this->ask('Nama Admin');
        $email = $this->argument('email') ?? $this->ask('Email Admin');
        $password = $this->argument('password') ?? $this->secret('Password Admin');

        // Validasi email unik
        if (User::where('email', $email)->exists()) {
            $this->error('Email sudah terdaftar!');
            return 1;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info('Admin user berhasil dibuat!');
        $this->info("Email: {$email}");
        return 0;
    }
}
