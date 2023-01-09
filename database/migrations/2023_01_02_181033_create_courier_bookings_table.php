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
        Schema::create('courier_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('document_image');
            $table->string('document_image_path');
            $table->string('pick_up_address')->nullable();
            $table->string('drop_address')->nullable();
            $table->string('pick_up_type')->nullable();
            $table->dateTime('schedule_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('courier_bookings');
    }
};
