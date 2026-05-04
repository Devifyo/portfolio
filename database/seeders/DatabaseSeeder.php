<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\EmailTemplateSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('pass@admin'),
            ]
        );

        // is_admin is intentionally excluded from $fillable — set directly
        if (!$admin->is_admin) {
            $admin->is_admin = true;
            $admin->save();
        }

        $this->call(EmailTemplateSeeder::class);
    }
}
