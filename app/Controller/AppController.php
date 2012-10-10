<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {
	public $components = array('RequestHandler', 'Cookie');

	public $uses = array('User', 'Token', 'Key');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Cookie->name = 'rest';
	}
	
	protected function isSigned() {
		$query = $this->request->query;		
		if (!empty($query['hash'])) {
			$token = $this->Token->getById($this->Cookie->read('Auth.token'));	
			if (!empty($token)) {
				$hashVerification = hash(Configure::read('Security.hashAlgo'), $token['Token']['id'] . strtolower($_SERVER['REQUEST_METHOD'] . $this->name . $token['Key']['secret']));
				if ($query['hash'] != $hashVerification) {
					// no token in session
					$this->response->statusCode(401);
					$errors = array('auth' => 'Hash signature incorrect.');
					$this->set(array(
						'errors' => $errors,
						'_serialize' => array('errors')
					));	
				} else {
					// hash is ok
					return true;
				}
			} else {
				// no token in session
				$this->response->statusCode(401);
				$errors = array('auth' => 'No token in cookie, call /auth to get a token.');
				$this->set(array(
					'errors' => $errors,
					'_serialize' => array('errors')
				));	
			}
		} else {
			// no hash in parameters
			$this->response->statusCode(401);
			$errors = array('hash' => 'Parameter hash is required.');
			$this->set(array(
				'errors' => $errors,
				'_serialize' => array('errors')
			));		
		}
	}
}
