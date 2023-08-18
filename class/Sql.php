<?php
class Sql extends PDO {
  private $conn;

  public function __construct($host,$dbname){
    $this->conn = new PDO("mysql:dbname=$dbname;host=$host","root","root");
  }
  public function setParams($statment,$params=array()){
    foreach ($params as $key => $value) {
      $this->setParam($statment,$key,$value);
    }
  }

  public function setParam($statment,$key,$value){
    $statment->bindParam($key,$value);
  }

  public function query($rawQuery,$params=array()){
      $stmt = $this->conn->prepare($rawQuery);
      $this->setParams($stmt,$params);
      $stmt->execute();
      return $stmt;
  }
  public function select($query,$params=array()){
    $stmt = $this->query($query,$params);
    $resultado = $stmt->fetchALl(PDO::FETCH_ASSOC);
    return json_encode($resultado);
  }
}
?>