<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegGruPermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SEG_GRUPERMISO', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idGrupo')->constrained('SEG_GRUPO');
            $table->foreignId('idModulo')->constrained('SEG_MODULO');
            $table->boolean('view')->default(false);
            $table->boolean('read')->default(false);
            $table->boolean('write')->default(false);
            $table->boolean('update')->default(false);
            $table->boolean('delete')->default(false);
            $table->timestamps();
            $table->boolean('estado')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SEG_GRUPERMISO');
    }
}
