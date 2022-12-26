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
        Schema::table('stores', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->boolean('free_delivery')->default(1);
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('lat')->nullable();
            $table->string('log')->nullable();
            $table->string('location')->nullable();
            $table->string('like')->nullable();
            $table->string('delivery_prize')->nullable();
            $table->string('delivery_time')->nullable();
            $table->boolean('is_prime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            //
        });
    }
};
