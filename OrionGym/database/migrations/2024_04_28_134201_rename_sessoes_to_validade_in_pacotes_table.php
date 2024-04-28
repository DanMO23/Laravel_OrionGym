<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSessoesToValidadeInPacotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pacotes', function (Blueprint $table) {
            $table->renameColumn('quantidade_sessoes', 'validade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pacotes', function (Blueprint $table) {
            $table->renameColumn('quantidade_sessoes', 'sessoes');
        });
    }
}

