<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessageScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_schedule', function (Blueprint $table) {
            $table->unsignedInteger('message_id');
            $table->unsignedInteger('schedule_id');
            $table->unsignedInteger('offset');
            
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
        Schema::drop('message_schedule');
    }
}
