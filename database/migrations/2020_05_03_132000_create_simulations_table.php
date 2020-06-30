<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulations', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedInteger('orientation');
            $table->float('wall_width');
            $table->string('wall_material');
            $table->boolean('ext_plaster');
            $table->boolean('int_plaster');
//            $table->string('country');
            $table->string('city')->index();
            $table->integer('heat_loss')->nullable();
            $table->unsignedFloat('mould');
            $table->unsignedFloat('u_value');

            $table->string('insulation_system')->nullable();
            $table->unsignedInteger('insulation_thickness')->nullable();

            $table->float('environment_impact')->nullable();
            $table->float('algae')->nullable();
            $table->float('rain')->nullable();
            $table->unsignedFloat('surface_temp')->nullable();
            $table->float('lambda_value')->nullable();

            $table->geometry('loc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simulations');
    }
}
