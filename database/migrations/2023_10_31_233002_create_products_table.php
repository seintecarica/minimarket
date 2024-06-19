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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('marca_id')->unsigned();
            $table->bigInteger('categoria_id')->unsigned();
            $table->string('nombre');
            $table->bigInteger('unidad_id')->unsigned();
            $table->integer('precio');
            $table->integer('min');
            $table->bigInteger('usuario_id')->unsigned();
            $table->timestamps();
            $table->string('estado');
            
            $table->foreign('marca_id')->references('id')->on('brands')
                    ->onUpdate('cascade');

            $table->foreign('categoria_id')->references('id')->on('categories')
                    ->onUpdate('cascade');

            $table->foreign('unidad_id')->references('id')->on('units')
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
        Schema::dropIfExists('products');
    }
};
