<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValorantStatsTable extends Migration
{
    public function up()
    {
        Schema::create('valorant_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jogador');
            $table->string('rank')->nullable();
            $table->string('agente_preferido')->nullable();
            $table->string('funcao_preferida')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('valorant_stats');
    }
}

?>
