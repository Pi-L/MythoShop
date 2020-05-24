<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'products';

    /**
     * Run the migrations.
     * @table py_products
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->string('name', 50);
            $table->string('excerpt', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->float('price', 11, 2);
            $table->unsignedInteger('quantity')->default(0);

            $table->boolean('is_active')->default(1);

            $table->unsignedBigInteger('categorie_id');

            $table->timestamps();

            $table->foreign('categorie_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
