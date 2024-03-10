<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio', function (Blueprint $table) {
            $table->bigIncrements('id',        )->length(10);
            $table->string('name',              255);
            $table->string('url',               255);
            $table->string('description',       255);
            $table->string('short_description', 255);
            $table->integer('ordering'             )->length(10)->unsigned()->nullable();
            $table->enum('status', array('hidden', 'published', 'pending'));
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolio');
    }
}
