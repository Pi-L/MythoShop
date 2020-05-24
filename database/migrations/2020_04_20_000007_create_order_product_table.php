<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'order_product';

    /**
     * Run the migrations.
     * @table py_link_products_orders
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('order_id');

            $table->unsignedInteger('quantity');
            $table->float('current_price', 11, 2);

            $table->timestamps();

            $table->index(["order_id", "product_id"]);

            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('product_id')
                ->references('id')->on('products')
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
