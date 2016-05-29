<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateScriptsTable
 */
class CreateScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scripts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->timestamps();
        });
        Schema::create('message_script', function (Blueprint $table) {
            $table->integer('message_id')->unsigned();
            $table->integer('script_id')->unsigned();
            $table->integer('offset')->unsigned();

            $table->foreign(['message_id'])->references('id')->on('messages');
            $table->foreign(['script_id'])->references('id')->on('scripts');
        });
        Schema::table('schedules', function (Blueprint $table) {
            $table->integer('script_id')->nullable();
            $table->integer('channel_id')->nullable();

            $table->foreign(['script_id'])->references('id')->on('scripts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
//            $table->dropColumn('channel_id');
            $table->dropColumn('script_id');
        });
        Schema::drop('message_script');
        Schema::drop('scripts');
    }
}
