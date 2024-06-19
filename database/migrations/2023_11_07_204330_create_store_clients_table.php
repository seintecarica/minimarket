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
        Schema::create('store_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('bodega_id')->unsigned();
            $table->timestamps();
            $table->string('estado');

            $table->foreign('cliente_id')->references('id')->on('customers')
                    ->onUpdate('cascade');
            $table->foreign('bodega_id')->references('id')->on('stores')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_clients');
    }
};
