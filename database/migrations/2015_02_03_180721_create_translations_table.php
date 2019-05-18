<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('locale_id')->unsigned();
            $table->integer('translation_id')->unsigned()->nullable();
            $table->text('translation');

            $table->foreign('locale_id')->references('id')->on('locales')
                ->onUpdate('restrict')
                ->onDelete('cascade');

            $table->foreign('translation_id')->references('id')->on('translations')
                ->onUpdate('restrict')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
