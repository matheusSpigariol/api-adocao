<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('endereco')->nullable();
            $table->string('foto')->nullable();
            $table->string('data_aniversario')->nullable();

            $table->foreign('endereco')->references('id')->on('endereco');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('endereco');
            $table->dropColumn('foto');
            $table->dropColumn('data_aniversario');
        });
    }
};
