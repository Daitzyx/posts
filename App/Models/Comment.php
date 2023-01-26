<?php

 namespace App\Models;

 use MF\Model\Model;

 class Comment extends Model {

  private $id;
  private $id_post;
  private $id_comment;
  private $nome;
  private $message;
  private $date;

  public function __get($atributo) {
    return $this->$atributo;
  }
  
  public function __set($atributo, $valor) {
    $this->$atributo = $valor;
  }

  public function create() {
    $query = "insert into comments(id_post, nome, message, id_comment)values(:id_post , :nome, :message, :id_comment)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_post', $this->__get('id_post'));
    $stmt->bindValue(':id_comment', $this->__get('id_comment'));
    $stmt->bindValue(':nome', $this->__get('nome'));
    $stmt->bindValue(':message', $this->__get('message'));
    $stmt->execute();

    return $this;

  }

  public function getAll($id_post) {
    $query = "
        select
          id,
          id_post,
          id_comment,
          nome,
          message,
          Date_FORMAT(date_message, '%d/%m/%dY %H:%i') as data
        from 
          comments
        where
          id_post = $id_post
        ";

      $stmt = $this->db->prepare($query);
      // $stmt->bindValue(':author',$this->__get('author'));
      $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getAllAnswers($id_post, $id_comment) {
			$query = "
        select
          id,
          id_post,
          id_comment,
          nome,
          message,
          Date_FORMAT(date_message, '%d/%m/%dY %H:%i') as data
        from 
          comments
        where
          id_comment = $id_comment and
          id_post = $id_post
        ";
			$stmt = $this->db->prepare($query);
      $stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
  
}