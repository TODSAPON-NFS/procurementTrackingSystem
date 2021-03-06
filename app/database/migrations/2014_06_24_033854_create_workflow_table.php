<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowTable extends Migration {

	public function up()
	{
		Schema::create('workflow', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('workFlowName', 255)->nullable();
			$table->integer('totalDays')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('workflow');
	}

}
