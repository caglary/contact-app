<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::table('kasadefteri',function($table){
            $table->enum('odeme_sekli',['card','nakit','eft']);
            
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kasadefteri', function($table) {
            $table->dropColumn('odeme_sekli');
        });
    }
};
