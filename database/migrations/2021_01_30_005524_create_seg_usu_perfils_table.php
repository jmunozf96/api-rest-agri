<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegUsuPerfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SEG_USUPERFIL', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUsuario')->constrained('SEG_USUARIO');
            $table->foreignId('idGrupo')->constrained('SEG_GRUPO');
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
        Schema::dropIfExists('SEG_USUPERFIL');
    }
}
