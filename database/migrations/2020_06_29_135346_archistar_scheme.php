<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArchistarScheme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->uuid('guid');
            $table->string('suburb');
            $table->string('state');
            $table->string('country');
        });

        Schema::create('analytic_types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('units');
            $table->boolean('is_numeric');
            $table->integer('num_decimal_places');
        });

        Schema::create('property_analytics', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('property_id');
            $table->foreign('property_id')
                ->references('id')
                ->on('properties');
            $table->unsignedInteger('analytic_type_id');
            $table->foreign('analytic_type_id')
                ->references('id')
                ->on('analytic_types');
            $table->text('value');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_analytics');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('analytic_types');
    }
}
