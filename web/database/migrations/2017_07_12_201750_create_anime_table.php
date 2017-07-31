<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('image_url');
            $table->tinyInteger('company_id');
            $table->string('date');
            $table->string('genres');
            $table->double('shikimori_rating');
            $table->double('worldart_rating')->default(0.00);
            $table->string('image_name');
            $table->tinyInteger('status')->default(1); // 0 - онгоинг, 1 - вышел
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anime');
    }
}
