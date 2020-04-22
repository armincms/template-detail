<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('template_details', function (Blueprint $table) { 
            $table->bigIncrements('id');          
            $table->string('name')->nullable(); 
            $table->string('label')->nullable();     
            $table->string('schema', 500)->nullable();   
            $table->config();   
            $table->timestamps(); 
            $table->softDeletes();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('template_details');
    }
}
