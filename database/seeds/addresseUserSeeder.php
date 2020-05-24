<?php

use Illuminate\Database\Seeder;

class AddresseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/addresseUser.sql');
        DB::unprepared($sql);
    }
}
