<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alunos_personal', function (Blueprint $table) {
            if (!Schema::hasColumn('alunos_personal', 'dia_vencimento')) {
                $table->integer('dia_vencimento')->default(10)->after('data_vencimento');
            }
        });
    }

    public function down(): void
    {
        Schema::table('alunos_personal', function (Blueprint $table) {
            $table->dropColumn('dia_vencimento');
        });
    }
};
