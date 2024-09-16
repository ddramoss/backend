<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncate('users');

        User::insert([
            [
                'name' => 'Diego Ramos',
                'email' => 'diego@example.com',
                'password' => Hash::make('pass123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ana Gómez',
                'email' => 'ana@example.com',
                'password' => Hash::make('pass123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * truncate
     *
     * @param  string $table
     * @return void
     */
    public function truncate(string $table): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS =0;');
        DB::table($table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS =1;');
    }
}
