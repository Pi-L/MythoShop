<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'orders';

    /**
     * Run the migrations.
     * @table py_orders
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('billing_addresse_id');
            $table->unsignedBigInteger('shipping_addresse_id')->default(1);


            $table->float('taxes', 11, 2);
            $table->float('total_ht', 11, 2);
            $table->float('total_ttc', 11, 2);
            $table->smallInteger('status')->default(1);
            $table->string('payment_id', 255);
            $table->string('shipping_type', 50);

            $table->timestamps();


            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('billing_addresse_id')
                ->references('id')->on('addresses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('shipping_addresse_id')
                ->references('id')->on('addresses')
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
