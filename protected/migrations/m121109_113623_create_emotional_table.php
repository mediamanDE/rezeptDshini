<?php

class m121109_113623_create_emotional_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('emotional', array(
			'id' => 'pk',
			'title' => 'string',
			'create'=> 'DATETIME',
			'update'=> 'DATETIME',
		));
	}

	public function down()
	{
		echo "m121109_113623_create_emotional_table does not support migration down.\n";
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