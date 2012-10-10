<?php
App::uses('AppModel', 'Model');

class Token extends AppModel {
	public $name = 'Token';
	
    public $belongsTo = array(
        'Key' => array(
            'className'    => 'Key',
            'foreignKey'    => 'key'
        )
    );
	
	public function check($email, $key, $validityTime = null) {
		// token validity time		
		$date = null;
		if (!empty($validityTime)) {
			$date = date('Y-m-d H:i:s', strtotime('-' . $validityTime));
		}
		
		$token = $this->get($email, $key, $date);
		if (empty($token)) {
			$data = array (
				'email' => $email,
				'key' => $key,
				'id' => $this->getTokenId($email, $key)
			);
			// create the token
			$token = $this->save($data, false);
		}
		return $token['Token']['id'];
	}
	
	public function getById($token) {
		return $this->find(
			'first',
			array(
				'token' => array (
					'id' => $token
				)
			)
		);
	}
	
	protected function get($email, $key, $date = null) {
		$conditions = array(
			'Token.email' => $email,
			'Token.key' => $key
		);
		if (!empty($date)) {
			$conditions['Token.created >='] = $date;
		}
		return $this->find('first', array('conditions' => $conditions));
	}
	
	protected function getTokenId($email, $key) {
		$token = hash (Configure::read('Security.hashAlgo'), Configure::read('Security.salt') . $email . $key . uniqid());
		return $token;
	}
}