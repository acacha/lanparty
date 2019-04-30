<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlagGroupPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flag_group', function (Blueprint $table) {
            $table->integer('flag_id')->unsigned()->index();
            $table->foreign('flag_id')->references('id')->on('flags')->onDelete('cascade');
            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->primary(['flag_id', 'group_id']);

            $table->dateTime('captured');
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
        Schema::drop('flag_group');
    }
}
