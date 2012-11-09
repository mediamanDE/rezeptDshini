<?php

class m121109_113942_create_recipe_rational_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('recipe_rational', array(
			'recipe_id' => 'int',
			'rational_id' => 'int',
		));
	}

	public function down()
	{
		echo "m121109_113942_create_recipe_rational_table does not support migration down.\n";
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