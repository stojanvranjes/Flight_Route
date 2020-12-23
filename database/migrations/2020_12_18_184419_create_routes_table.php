<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('airline');
            $table->bigInteger('airline_id');
            $table->string('source_airport');
            $table->bigInteger('source_airport_id')->index();
            $table->string('destination_airport');
            $table->bigInteger('destination_airport_id')->index();
            $table->string('codeshare')->nullable();
            $table->integer('stops');
            $table->string('equipment');
            $table->decimal('price', 6, 2);
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
        Schema::dropIfExists('routes');
    }
}
