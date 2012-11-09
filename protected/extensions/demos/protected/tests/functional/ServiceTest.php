<?php

class ServiceTest extends WebTestCase
{
	public $fixtures=array(
		'services'=>'Service',
	);

	public function testShow()
	{
		$this->open('?r=service/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=service/create');
	}

	public function testUpdate()
	{
		$this->open('?r=service/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=service/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=service/index');
	}

	public function testAdmin()
	{
		$this->open('?r=service/admin');
	}
}
