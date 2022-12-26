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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image');
            $table->string('image_path');
            $table->double('price',15,2);
            $table->double('discount_price',15,2)->default(0);
            $table->string('capacity')->nullable()->default(1);
            $table->bigInteger('available_qty')->nullable();
            $table->boolean('deliverable')->default(1);
            $table->bigInteger('vendor_type_id')->nullable();
            $table->bigInteger('store_id')->nullabel();
            $table->bigInteger('categorie_id')->nullable();
            $table->boolean('deleted_at')->default(0);
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
        Schema::dropIfExists('products');
    }
};
