<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtchetStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {		
		Schema::create('otchet_statuses', function (Blueprint $table) {
            $table->id();			
			$table->integer('userid')->notnullable();
			$table->integer('formid')->notnullable();
			$table->string('categorytable')->notnullable();
			$table->integer('category')->notnullable();
			$table->integer('status')->notnullable();
			$table->date('plandate')->notnullable();
			$table->date('realdate')->nullable();			
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
        Schema::dropIfExists('otchet_statuses');
    }
}
