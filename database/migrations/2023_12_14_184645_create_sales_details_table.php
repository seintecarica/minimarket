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
        Schema::create('sales_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bodega_id')->unsigned();
            $table->bigInteger('pago_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->bigInteger('unidad_id')->unsigned();
            $table->integer('cantidad');
            $table->integer('precio');
            $table->timestamps();

            $table->foreign('bodega_id')->references('id')->on('stores')
                    ->onUpdate('cascade');
            $table->foreign('pago_id')->references('id')->on('payment_forms')
                    ->onUpdate('cascade');
            $table->foreign('producto_id')->references('id')->on('products')
                    ->onUpdate('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')
                    ->onUpdate('cascade');
            $table->foreign('unidad_id')->references('id')->on('units')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};
