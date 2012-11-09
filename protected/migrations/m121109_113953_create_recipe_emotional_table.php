<?php

class m121109_113953_create_recipe_emotional_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('recipe_emotional', array(
			'recipe_id' => 'int',
			'emotional_id' => 'int',
		));	
	}

	public function down()
	{
		echo "m121109_113953_create_recipe_emotional_table does not support migration down.\n";
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