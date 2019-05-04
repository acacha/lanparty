<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyIndexesOnNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('numbers', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('numbers');

            if(array_key_exists('numbers_value_unique', $indexesFound))
                $table->dropUnique('numbers_value_unique');
            $table->unique(['value','session'],'numbers_index_value_session');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('numbers', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('numbers');

            if(array_key_exists('numbers_index_value_session', $indexesFound)) {
                $table->dropUnique('numbers_index_value_session');
            }
            $table->unique('value');
        });
    }
}
