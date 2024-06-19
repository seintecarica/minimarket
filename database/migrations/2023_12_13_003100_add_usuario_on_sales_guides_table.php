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
        Schema::table('sales_guides', function (Blueprint $table) {
            $table->bigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_guides', function (Blueprint $table) {
            //
        });
    }
};
