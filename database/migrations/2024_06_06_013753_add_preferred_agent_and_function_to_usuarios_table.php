<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreferredAgentAndFunctionToUsuariosTable extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('preferred_agent')->nullable();
            $table->string('preferred_function')->nullable();
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('preferred_agent');
            $table->dropColumn('preferred_function');
        });
    }
}
