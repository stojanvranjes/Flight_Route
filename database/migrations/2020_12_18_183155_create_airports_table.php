<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('airport_id')->unsigned()->index();
            $table->string('name');
            $table->bigInteger('cities_id')->index();
            $table->bigInteger('countries_id')->index();
            $table->string('IATA')->nullable();
            $table->string('ICAO')->nullable();
            $table->decimal('latitude', 8, 6);
            $table->decimal('longitude', 9, 6);
            $table->integer('altitude');
            $table->integer('timezone_offset')->nullable();
            $table->string('DST')->nullable();
            $table->string('timezone')->nullable();
            $table->string('type');
            $table->string('source');
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
        Schema::dropIfExists('airports');
    }
}
