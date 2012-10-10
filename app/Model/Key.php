<?php
App::uses('AppModel', 'Model');

class Key extends AppModel {
	public $name = 'Key';
	
	public function get($key) {
		return $this->find(
			'first',
			array(
				'conditions' => array (
					'id' => $key
				)
			)
		);
	}
}