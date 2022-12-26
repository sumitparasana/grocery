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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price',15,2)->nullable();
            $table->boolean('is_available')->default(1);
            $table->bigInteger('product_id');
            $table->bigInteger('categorie_id')->nullable();
            $table->bigInteger('store_id')->nullable();
            $table->bigInteger('vendor_type_id')->nullable();
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
        Schema::dropIfExists('product_categories');
    }
};
