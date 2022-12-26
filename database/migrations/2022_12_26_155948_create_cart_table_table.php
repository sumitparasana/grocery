<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_table', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('devices_id');
            $table->integer('product_id');
            $table->integer('store_id');
            $table->integer('vendor_type_id');
            $table->integer('product_count');
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
        Schema::dropIfExists('cart_table');
    }
};
