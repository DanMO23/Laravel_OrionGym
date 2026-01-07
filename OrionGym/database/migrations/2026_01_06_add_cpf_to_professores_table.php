<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('professores', function (Blueprint $table) {
            if (!Schema::hasColumn('professores', 'cpf')) {
                $table->string('cpf', 14)->nullable()->unique()->after('nome_completo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('professores', function (Blueprint $table) {
            $table->dropColumn('cpf');
        });
    }
};
