<?php

 namespace App\Models;

 use MF\Model\Model;

 class Author extends Model {

  private $id;
  private $author;

  public function __get($atributo) {
    return $this->$atributo;
  }
  
  public function __set($atributo, $valor) {
    $this->$atributo = $valor;
  }

  public function create() {
    $query = "insert into authors(author)values(:author)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':author', $this->__get('author'));
    
    $stmt->execute();

    return $this;
  }

  public function get() {
    $query = "
    select 
      *
    from
      authors
    ";
    $stmt = $this->db->prepare($query);
    
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);;
  }


 }

?>
