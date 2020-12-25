<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemTwosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_twos', function (Blueprint $table) {
            $table->id();
            $table->double('arrive_rate')->nullable(true);
            $table->double('service_rate')->nullable(true);
            $table->double('capacity')->nullable(true);
            $table->double('servers')->nullable(true);
            $table->double('Po')->nullable(true);
            $table->double('Pn')->nullable(true);
            $table->double('p')->nullable(true);
            $table->double('L')->nullable(true);
            $table->double('Lq')->nullable(true);
            $table->double('W')->nullable(true);
            $table->double('Wq')->nullable(true);
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
        Schema::dropIfExists('system_twos');
    }
}
