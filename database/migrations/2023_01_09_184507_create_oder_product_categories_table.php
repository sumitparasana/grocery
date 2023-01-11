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
        Schema::create('oder_product_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('oder_id')->nullable();
            $table->bigInteger('oder_product_id')->nullable();
            $table->bigInteger('product_categories_id')->nullable();
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
        Schema::dropIfExists('oder_product_categories');
    }
};
