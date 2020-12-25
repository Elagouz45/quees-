<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems', function (Blueprint $table) {
            $table->id();
            $table->string('service_time');
            $table->string('interarrival_time');
            $table->string('capacity');
            $table->integer('K')->nullable(true);
            $table->integer('M')->nullable(true);
            $table->integer('ti')->nullable(true);
            $table->text('n1')->nullable(true);
            $table->text('n2')->nullable(true);
            $table->text('n3')->nullable(true);
            $table->text('wq1')->nullable(true);
            $table->text('wq2')->nullable(true);
            $table->text('wq3')->nullable(true);
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
        Schema::dropIfExists('systems');
    }
}
