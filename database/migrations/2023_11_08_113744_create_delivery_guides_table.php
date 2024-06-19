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
        Schema::create('delivery_guides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('folio');
            $table->bigInteger('bodega_origen')->unsigned();
            $table->bigInteger('bodega_destino')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->timestamps();
            $table->string('estado');

            $table->foreign('bodega_origen')->references('id')->on('stores')
                    ->onUpdate('cascade');
            $table->foreign('bodega_destino')->references('id')->on('stores')
                    ->onUpdate('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_guides');
    }
};
