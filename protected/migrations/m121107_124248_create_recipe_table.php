<?php

class m121107_124248_create_recipe_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('recipe', array(
			'id' => 'pk',
			'title' => 'string',
			'ingredients' => 'text',
			'preparation' => 'text',
			'create'=> 'DATETIME',
			'update'=> 'DATETIME',
		));
	}

	public function down()
	{
		echo "m121107_124248_create_recipe_table does not support migration down.\n";
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