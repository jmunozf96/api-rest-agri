<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SEG_MODULO', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idTModulo')->constrained('SEG_TIPOMODULO');
            $table->string('nombre', 100);
            $table->string('descripcion', 250);
            $table->string('url', 300)->nullable();
            $table->string('icon', 150)->nullable();
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
        Schema::dropIfExists('SEG_MODULO');
    }
}
