<?php

class BookTest extends WebTestCase
{
	public $fixtures=array(
		'books'=>'Book',
	);

	public function testShow()
	{
		$this->open('?r=book/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=book/create');
	}

	public function testUpdate()
	{
		$this->open('?r=book/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=book/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=book/index');
	}

	public function testAdmin()
	{
		$this->open('?r=book/admin');
	}
}
