<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('match_id');
            $table->bigInteger('team_id');
            $table->bigInteger('player_id');
            $table->enum('field_site',['Home','Away'])->default('Home');
            $table->enum('type',['Goal','Foul'])->default('Goal'); 
            $table->enum('match_duration',['First Half','Second Half'])->default('First Half'); 
            $table->text('remarks')->nullable();
            $table->integer('event_time')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goals');
    }
}
