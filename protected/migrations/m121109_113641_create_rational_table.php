<?php

class m121109_113641_create_rational_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('rational', array(
			'id' => 'pk',
			'title' => 'string',
			'create'=> 'DATETIME',
			'update'=> 'DATETIME',
		));
	}

	public function down()
	{
		echo "m121109_113641_create_rational_table does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}