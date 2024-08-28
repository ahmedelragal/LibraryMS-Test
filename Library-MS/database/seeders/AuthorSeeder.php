<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'Ahmed Elragal',
            'email' => 'ahmed@gmail.com',
        ]);
        Author::create([
            'name' => 'Omar Ahmed',
            'email' => 'omar@gmail.com',
        ]);
        Author::create([
            'name' => 'Mohamed Hassan',
            'email' => 'mohamed@yahoo.com',
        ]);
    }
}
