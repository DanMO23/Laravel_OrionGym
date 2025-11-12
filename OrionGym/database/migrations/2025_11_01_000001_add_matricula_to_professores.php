<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('professores', function (Blueprint $table) {
            // Verifica se a coluna não existe antes de adicionar
            if (!Schema::hasColumn('professores', 'numero_matricula')) {
                $table->string('numero_matricula')->unique()->nullable()->after('id');
            }
        });
    }

    public function down()
    {
        Schema::table('professores', function (Blueprint $table) {
            if (Schema::hasColumn('professores', 'numero_matricula')) {
                $table->dropColumn('numero_matricula');
            }
        });
    }
};
