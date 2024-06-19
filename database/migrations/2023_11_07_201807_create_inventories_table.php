<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bodega_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('bodega_id')->references('id')->on('stores')
                    ->onUpdate('cascade');
            $table->foreign('producto_id')->references('id')->on('products')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
