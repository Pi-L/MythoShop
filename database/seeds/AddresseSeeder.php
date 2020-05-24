<?php

use Illuminate\Database\Seeder;

class AddresseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/addresses.sql');
        DB::unprepared($sql);
    }
}
