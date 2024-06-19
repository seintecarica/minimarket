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
        Schema::create('delivery_detail_guides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('guia_entrega_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->integer('cantidad');

            $table->foreign('guia_entrega_id')->references('id')->on('delivery_guides')
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
        Schema::dropIfExists('delivery_detail_guides');
    }
};
