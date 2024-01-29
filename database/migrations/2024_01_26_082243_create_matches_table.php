<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('user_id');
            $table->bigInteger('home_team_id');
            $table->bigInteger('away_team_id');
            $table->bigInteger('winner_team_id')->nullable();
            $table->bigInteger('loser_team_id')->nullable();
            $table->date('date');
            $table->integer('time')->default(0);
            $table->integer('status')->default(0); //  1 for first half, 2 for break time, 3 for second haif 4 is end
            $table->string('slug');
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
        Schema::dropIfExists('matches');
    }
}
