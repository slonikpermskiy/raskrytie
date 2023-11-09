<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtchetPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otchet_plans', function (Blueprint $table) {
            $table->id();			
			$table->integer('userid')->notnullable();
			$table->string('categorytable')->notnullable();
			$table->integer('category')->notnullable();
			$table->integer('formid')->notnullable();
			$table->date('firstdate')->notnullable();			
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
        Schema::dropIfExists('otchet_plans');
    }
}
