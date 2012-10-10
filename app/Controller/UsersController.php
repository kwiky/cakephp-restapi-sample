<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
	public $name = 'Users';
	
	/**
	 * Create a user
	 */
	public function create() {
		$user = $this->User->save($this->request->data);
		
        if (!empty($user)) {
            $this->response->statusCode(201);
			$user = $user['User'];
			unset($user['password']);
			$this->set(array(
				'user' => $user,
				'_serialize' => array('user')
			));
		} else {
			$this->response->statusCode(400);
			$errors = $this->User->validationErrors;
			$this->set(array(
				'errors' => $errors,
				'_serialize' => array('errors')
			));
		}
    }
	
	/**
	 * Auth user and return a token
	 */
	public function auth() {
		$query = $this->request->query;		
		if (!empty($query['key'])) {
			// check key
			$key = $this->Key->get($query['key']);
			if (!empty($key)) {
				// check user
				$user = $this->User->auth($this->request->data);
				if (!empty($user)) {
					// check token
					$token = $this->Token->check(
						$this->request->data['email'], 
						$query['key'],
						Configure::read('Security.tokenValidityTime')
					);
					if (!empty($token)) {
						$this->response->statusCode(200);
						$user = $user['User'];
						unset($user['password']);
						$this->Cookie->write('Auth.token', $token);
						$this->set(array(
							'user' => $user,
							'token' => $token,
							'_serialize' => array('user', 'token')
						));
					} else {
						// can't get or generate a token
						$this->response->statusCode(400);
						$errors = $this->Token->validationErrors;
						$this->set(array(
							'errors' => $errors,
							'_serialize' => array('errors')
						));
					}
				} else {
					// user not found
					$this->response->statusCode(401);
					$errors = $this->User->validationErrors;
					$this->set(array(
						'errors' => $errors,
						'_serialize' => array('errors')
					));
				}
			} else {
				// unknown key
				$this->response->statusCode(400);
				$errors = array('key' => 'Unknown key.');
				$this->set(array(
					'errors' => $errors,
					'_serialize' => array('errors')
				));
			}
		} else {
			// no key in parameters
			$this->response->statusCode(400);
			$errors = array('key' => 'Parameter key is required.');
			$this->set(array(
				'errors' => $errors,
				'_serialize' => array('errors')
			));		
		}
    }
}