<?php
App::uses('AppModel', 'Model');

class User extends AppModel {
	public $name = 'User';
	
    public $validate = array(
        'email' => array(
			'email' => array(
				'rule' => 'email',
				'required' => 'create',
				'message' => 'Invalid email address.'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'required' => 'create',
				'message' => 'Email already exists.'
			),
		),
        'password' => array(
			'required' => true,
            'rule'    => array('minLength', '8'),
            'message' => 'Minimum 8 characters long.'
        ),
    );
	
	public function save($data = null, $validate = true, $fieldList = array()) {
		// Validate before the password hashing
		$this->set($data);
		if ($this->validates()) {
			$data['password'] =  $this->getPasswordHash($data['password']);
			return parent::save($data, false, $fieldList);
		}
		return null;
	}
	
	public function auth($data = null) {
		if (!empty($data['email'])) {
			// Validate before the password hashing
			$user = $this->find('first', array(
				'conditions' => array('User.email' => $data['email'])
			));
			if (empty($user)) {
				$this->validationErrors['email'] = 'User not found.';
				return null;
			} elseif($user['User']['password'] != $this->getPasswordHash($data['password'])) {
				$this->validationErrors['password'] = 'Invalid password.';
				return null;
			}
		} else {
			$this->validationErrors['email'] = 'Email required.';
			return null;
		}
		return $user;
	}
	
	protected function getPasswordHash($password) {
		return hash (Configure::read('Security.hashAlgo'), Configure::read('Security.salt') . $password);
	}
}