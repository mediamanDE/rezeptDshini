<?php

class LibraryTest extends WebTestCase
{
	public $fixtures=array(
		'libraries'=>'Library',
	);

	public function testShow()
	{
		$this->open('?r=library/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=library/create');
	}

	public function testUpdate()
	{
		$this->open('?r=library/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=library/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=library/index');
	}

	public function testAdmin()
	{
		$this->open('?r=library/admin');
	}
}
