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
        Schema::create('dispatch_guides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('folio');
            $table->bigInteger('bodega_id')->unsigned();
            $table->bigInteger('marca_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->timestamps();
            $table->string('estado');

            $table->foreign('bodega_id')->references('id')->on('stores')
                    ->onUpdate('cascade');
            $table->foreign('marca_id')->references('id')->on('brands')
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
        Schema::dropIfExists('dispatch_guides');
    }
};
