<?php
App::uses('AppController', 'Controller');

class ItemsController extends AppController {

	public $name = 'Items';
	
	public function create() {
		if ($this->isSigned()) {
			$item = array (
				'description' => 'This is a sample item'
			);
			$this->response->statusCode(201);
			$this->set(array(
				'item' => $item,
				'_serialize' => array('item')
			));
		}
    }
	
	public function read($id) {
		if ($this->isSigned()) {
			$item = array (
				'id' => $id,
				'description' => 'This is a sample item'
			);
			$this->response->statusCode(200);
			$this->set(array(
				'item' => $item,
				'_serialize' => array('item')
			));
		}
    }
	
	public function update() {
		if ($this->isSigned()) {
			$item = array (
				'description' => 'This is a sample item'
			);
			$this->response->statusCode(200);
			$this->set(array(
				'item' => $item,
				'_serialize' => array('item')
			));
		}
    }
	
	public function delete() {
		if ($this->isSigned()) {
			$item = array (
				'description' => 'This is a sample item'
			);
			$this->response->statusCode(200);
			$this->set(array(
				'item' => $item,
				'_serialize' => array('item')
			));
		}
    }
	
	public function index() {
		if ($this->isSigned()) {
			$item = array (
				'description' => 'This is a sample item'
			);
			$this->set(array(
				'item' => $item,
				'_serialize' => array('item')
			));
		}
    }
}