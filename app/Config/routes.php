<?php
Router::connect('/auth', array('controller' => 'users', 'action' => 'auth'));

Router::resourceMap(array(
	array('action' => 'index', 'method' => 'GET', 'id' => false),
	array('action' => 'read', 'method' => 'GET', 'id' => true),
	array('action' => 'create', 'method' => 'POST', 'id' => false),
	array('action' => 'update', 'method' => 'PUT', 'id' => true),
	array('action' => 'delete', 'method' => 'DELETE', 'id' => true)
));

Router::mapResources(array('users', 'items'));
Router::parseExtensions();
	
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';