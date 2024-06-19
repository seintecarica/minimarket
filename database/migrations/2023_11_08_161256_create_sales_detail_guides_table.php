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
        Schema::create('sales_detail_guides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('guia_venta_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->integer('cantidad');
            $table->integer('precio');
            $table->integer('subtotal');

            $table->foreign('guia_venta_id')->references('id')->on('sales_guides')
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
        Schema::dropIfExists('sales_detail_guides');
    }
};
