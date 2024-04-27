<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacotesTable extends Migration
{
    public function up()
    {
        Schema::create('pacotes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_pacote');
            $table->decimal('valor', 8, 2);
            $table->integer('quantidade_sessoes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pacotes');
    }
}
