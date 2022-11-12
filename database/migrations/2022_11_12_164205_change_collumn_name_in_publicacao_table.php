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
        Schema::table('publicacao', function (Blueprint $table) {
            $table->renameColumn('user', 'usuario');
            $table->renameColumn('description', 'descricao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('publicacao', function (Blueprint $table) {
            $table->renameColumn('usuario', 'user');
            $table->renameColumn('descricao', 'description');
        });
    }
};
