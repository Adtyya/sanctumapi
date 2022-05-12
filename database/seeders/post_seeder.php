<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;

class post_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<3;$i++){
            Post::create([
                'title' => 'acmrit',
                'body' => 'awikwok',
                'image' => 'acmrit',
                'category_id' => 3,
                'user_id' => 3
            ]);
        }        
    }
}
