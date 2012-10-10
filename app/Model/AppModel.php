<?php
App::uses('Model', 'Model');

class AppModel extends Model {

	public function save($data = null, $validate = true, $fieldList = array()) {
		if (empty($data['id'])) {
			$data['id'] = $this->generateId();
		}
		return parent::save($data, $validate, $fieldList);
	}
	
	protected function generateId() {
		return uniqid(substr(strtolower($this->name), 0, 8).'-', true);
	}
}
