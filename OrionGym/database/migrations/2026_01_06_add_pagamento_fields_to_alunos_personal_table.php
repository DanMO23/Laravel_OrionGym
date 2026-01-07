<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alunos_personal', function (Blueprint $table) {
            if (!Schema::hasColumn('alunos_personal', 'status_pagamento')) {
                $table->enum('status_pagamento', ['pago', 'pendente', 'atrasado'])->default('pendente')->after('status');
            }
            if (!Schema::hasColumn('alunos_personal', 'ultimo_pagamento')) {
                $table->date('ultimo_pagamento')->nullable()->after('status_pagamento');
            }
            if (!Schema::hasColumn('alunos_personal', 'dias_restantes')) {
                $table->integer('dias_restantes')->default(0)->after('ultimo_pagamento');
            }
        });
    }

    public function down(): void
    {
        Schema::table('alunos_personal', function (Blueprint $table) {
            $table->dropColumn(['status_pagamento', 'ultimo_pagamento', 'dias_restantes']);
        });
    }
};
