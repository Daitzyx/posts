<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$addAuthor = isset($_POST['author']) ? $_POST['author'] : '';
		
		$author = Container::getModel('Author');

		if($addAuthor)
		{
			$author->__set('author', $addAuthor);
			$author->create();

			header("Location: /post");
		}

		$allAuthors = array();

		$this->view->allAuthors = $author->get();;

		$this->render('index');
	}

}


?>