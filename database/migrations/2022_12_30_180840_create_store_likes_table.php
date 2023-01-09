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
        Schema::create('store_likes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('vendor_type_id');
            $table->bigInteger('store_id');
            $table->boolean('is_like')->default(0);
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
        Schema::dropIfExists('store_likes');
    }
};
