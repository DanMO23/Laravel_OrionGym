<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAlunosTableMakeEmailNullable extends Migration
{
    public function up()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });
    }
}
