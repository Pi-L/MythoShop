<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'addresses';

    /**
     * Run the migrations.
     * @table py_addresses
     *
     * @return void
     */
    public function up()
    {
        // todo : add name and lastname to addresses (like amazon do)
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('number', 10);
            $table->string('street', 255);
            $table->string('postcode', 10);
            $table->string('town', 60);
            $table->string('country', 60)->default('FRANCE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
