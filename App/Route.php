<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['post'] = array(
			'route' => '/post',
			'controller' => 'postsController',
			'action' => 'post'
		);

		$routes['post_id'] = array(
			'route' => '/posted',
			'controller' => 'postsController',
			'action' => 'postId'
		);

		$routes['comment'] = array(
			'route' => '/posted',
			'controller' => 'commentController',
			'action' => 'comment'
		);

		$this->setRoutes($routes);
	}

}

?>