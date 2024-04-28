<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->string('endereco')->nullable()->after('email');
        });

        Schema::table('professores', function (Blueprint $table) {
            $table->string('endereco')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropColumn('endereco');
        });

        Schema::table('professores', function (Blueprint $table) {
            $table->dropColumn('endereco');
        });
    }
};
