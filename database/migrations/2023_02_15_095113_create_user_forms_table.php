<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_forms', function (Blueprint $table) {
            $table->id();
			$table->string('categorytable')->notnullable();
			$table->integer('category')->notnullable();
			$table->string('razdelname')->nullable();
			$table->string('otchetname')->notnullable();
			$table->longtext('reportdays')->notnullable();
			$table->longtext('whosend')->nullable();
			$table->string('otchetlink')->nullable();
			$table->string('organisation')->nullable();
			$table->integer('staff')->nullable();			
			$table->string('comment')->nullable();
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
        Schema::dropIfExists('user_forms');
    }
}
