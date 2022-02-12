<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('insert into images (path, concert_id, created_at, updated_at) values (?,?,?,?)', ['tomorrow1.jpg',1, date('Y-m-d H:i:s') , date('Y-m-d H:i:s')]);
        DB::insert('insert into images (path, concert_id, created_at, updated_at) values (?,?,?,?)', ['tomorrow2.jpg', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        DB::insert('insert into images (path, concert_id, created_at, updated_at) values (?,?,?,?)', ['rally1.jpg', 2, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        DB::insert('insert into images (path, concert_id, created_at, updated_at) values (?,?,?,?)', ['rally2.jpg', 2, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    }
}
