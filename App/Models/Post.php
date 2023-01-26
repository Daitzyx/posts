<?php

 namespace App\Models;

 use MF\Model\Model;

 class Post extends Model {

  private $id;
  private $post;
  private $photo;
  private $author;
  private $data;

  public function __get($atributo) {
    return $this->$atributo;
  }
  
  public function __set($atributo, $valor) {
    $this->$atributo = $valor;
  }

  public function getAll() {
    $query = "
        select
          p.id,
          p.author,
          p.post,
          a.author,
          Date_FORMAT(p.date_current, '%d/%m/%dY %H:%i') as data
        from 
          posts as p
          left join authors as a on (a.author = p.author)
        ";

      $stmt = $this->db->prepare($query);
      // $stmt->bindValue(':author',$this->__get('author'));
      $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getPost($id) {
    $query = "
        select
          id,
          author,
          post,
          Date_FORMAT(date_current, '%d/%m/%dY %H:%i') as data
        from 
          posts
        where 
          id = $id
        ";

      $stmt = $this->db->prepare($query);
      // $stmt->bindValue(':id', $this->__get('id'));

      $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function create() {
    $query = "insert into posts(author, post, photo)values(:author, :post, :photo)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':author', $this->__get('author'));
    $stmt->bindValue(':post', $this->__get('post'));
    $stmt->bindValue(':photo', $this->__get('photo'));
    $stmt->execute();

    return $this;

  }

  
 }