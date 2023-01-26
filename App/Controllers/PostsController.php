<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;


class PostsController extends Action {

	public function post() {

		$post = Container::getModel('Post');

		$author = isset($_POST['author']) ? $_POST['author'] : '';
		$postComment = isset($_POST['post']) ? $_POST['post'] : '';
		$photo = isset($_POST['photo']) ? $_POST['photo'] : '';
	
		$post->__set('author', $author);
		
		$allPosts = array();
		
		$this->view->allPosts = $post->getAll();

		if( $author && $postComment ) {
			$post->__set('author', $author);
			$post->__set('post', $postComment);
			$post->__set('photo', $photo);

			$post->create();

			header('Location: /post');

		}

		$author = Container::getModel('Author');

		$allAuthors = array();
		
		$this->view->allAuthors = $author->get();	

		$this->render('post');

	}

	public function postId() {

		if ($_POST['nome']) {
			$comment = Container::getModel('Comment');
			$idPost = isset($_GET['id']) ? $_GET['id'] : '';

			$idComment = isset($_POST['id_comment']) && $_POST['id_comment'] ? $_POST['id_comment'] : null;

			$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
			$commentText = isset($_POST['comment']) ? $_POST['comment'] : '';

			$comment->__set('id_comment', $idComment);
			$comment->__set('id_post', $idPost);
			$comment->__set('nome', $nome);
			$comment->__set('message', $commentText);
			
			$comment->create();
			
			header('Location: /posted?id='.$idPost);
		}

		$author = Container::getModel('Author');

		$allAuthors = array();
		$this->view->allAuthors = $author->get();	

		$idPost = isset($_GET['id']) ? $_GET['id'] : '';

		$post = Container::getModel('Post');

		$post->__set('id', $idPost);
		
		$postId = array();

		$this->view->postId = $post->getPost($idPost);	


		$comment = Container::getModel('Comment');

		$allComments = $comment->getAll($idPost);

		$commentsPost = array_filter($allComments, function($comment) {
			return !$comment['id_comment'];
		});
		
		$comments = $this->handleComments($commentsPost, $allComments);

		$this->view->comments = $comments;
		$this->view->allComment = $allComments;

		$this->render('postId');
		
	}

	public function handleComments($comments, $allComments)
	{
		if (count($comments)) {
				$comments = array_map(function($comment) use ($allComments) {

						$comment['responses'] = array_filter($allComments, function($response) use ($comment) {
								return $response['id_comment'] === $comment['id'] && $comment['id_comment'] !== $comment['id'];
						});

						if (count($comment['responses'])) {
								$comment['responses'] = $this->handleComments($comment['responses'], $allComments);
						}

						return $comment;
				}, $comments);
		}

		return $comments;
	}
}

?>