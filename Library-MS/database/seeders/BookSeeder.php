<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Book 1',
            'isbn' => '332',
            'published_date' => '2022-02-28',
            'author_id' => Author::where('name', 'Ahmed Elragal')->first()->id,
        ]);

        Book::create([
            'title' => 'Book 2',
            'isbn' => '268',
            'published_date' => '2002-08-26',
            'author_id' => Author::where('name', 'Ahmed Elragal')->first()->id,
        ]);
        Book::create([
            'title' => 'Book 3',
            'isbn' => '538',
            'published_date' => '2002-08-26',
            'author_id' => Author::where('name', 'Omar Ahmed')->first()->id,
        ]);
        Book::create([
            'title' => 'Book 4',
            'isbn' => '324',
            'published_date' => '2002-08-26',
            'author_id' => Author::where('name', 'Omar Ahmed')->first()->id,
        ]);
        Book::create([
            'title' => 'Book 5',
            'isbn' => '978',
            'published_date' => '2002-08-26',
            'author_id' => Author::where('name', 'Mohamed Hassan')->first()->id,
        ]);
    }
}
