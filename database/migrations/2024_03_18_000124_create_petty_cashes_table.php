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
        Schema::create('petty_cashes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('usuario_id')->unsigned();
            $table->integer('total_inicio')->default(0);

            $table->integer('ingr_v_efect')->default(0);
            $table->integer('ingr_v_deb')->default(0);
            $table->integer('ingr_v_transf')->default(0);
            $table->integer('ingr_v_gratis')->default(0);
            $table->integer('ingr_aportes')->default(0);

            $table->integer('ingr_total')->default(0);

            $table->integer('egre_p_fact')->default(0);
            $table->integer('egre_p_bol')->default(0);
            $table->integer('egre_p_otros')->default(0);

            $table->integer('egre_total')->default(0);

            $table->integer('total_transac')->default(0); // ingr_total - egre_total
            $table->integer('total_rendido')->default(0); // total_inicio + total_transac

            //----Monedas------------------------
            $table->integer('cant_10')->default(0);
            $table->integer('total_10')->default(0);
            $table->integer('cant_50')->default(0);
            $table->integer('total_50')->default(0);
            $table->integer('cant_100')->default(0);
            $table->integer('total_100')->default(0);
            $table->integer('cant_500')->default(0);
            $table->integer('total_500')->default(0);
            //Billetes
            $table->integer('cant_1000')->default(0);
            $table->integer('total_1000')->default(0);
            $table->integer('cant_2000')->default(0);
            $table->integer('total_2000')->default(0);
            $table->integer('cant_5000')->default(0);
            $table->integer('total_5000')->default(0);
            $table->integer('cant_10000')->default(0);
            $table->integer('total_10000')->default(0);
            $table->integer('cant_20000')->default(0);
            $table->integer('total_20000')->default(0);
            //-----------------------------------
            $table->integer('total_efect_esperado')->default(0);
            $table->integer('total_efect_rendido')->default(0);
            $table->integer('saldo')->default(0);

            $table->dateTime('closed_at')->nullable();
            $table->timestamps();
			$table->string('estado', 15);

            $table->foreign('usuario_id')->references('id')->on('users')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petty_cashes');
    }
};
