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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->integer('vendor_type_id')->nullable();
            $table->integer('store_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('oder_id')->nullable();
            $table->integer('address_id')->nullable();
            $table->string('tital')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_send')->default(0);
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
        Schema::dropIfExists('notifications');
    }
};
