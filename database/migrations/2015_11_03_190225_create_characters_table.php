<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->unsignedInteger('xp');
            $table->unsignedInteger('level');
            $table->integer('money');

            // health
            $table->integer('health');
            $table->integer('max_health');

            // mana
            $table->integer('mana');
            $table->integer('max_mana');

            // attributes
            $table->integer('strength');
            $table->integer('agility');
            $table->integer('intelligence');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

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
        Schema::drop('characters');
    }
}
