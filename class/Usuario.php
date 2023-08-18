<?php
class Usuario{
  private $idusuario;
  private $deslogin;
  private $dessenha;
  private $dtcadastro;

  public function getIdusuario(){
    return $this->idusuario;
  }
  public function setIdusuario($idusuario){
    $this->idusuario = $idusuario;
  }
  public function getDeslogin(){
    return $this->deslogin;
  }
  public function setDeslogin($deslogin){
    $this->deslogin = $deslogin;
  }
  public function getDessenha(){
    return $this->dessenha;
  }
  public function setDessenha($dessenha){
    $this->dessenha = $dessenha;
  }
  public function getDtcadastro(){
    return $this->dtcadastro;
  }
  public function setDtcadastro($dtcadastro){
    $this->dtcadastro = $dtcadastro;
  }

  public function loadById($id){
    $sql = new Sql("localhost","dbphp7");
    $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID",array(
      ":ID"=>$id
    ));
    $resultArray = json_decode($result,true);
    if($resultArray>0){
      $row = $resultArray[0];
      $this->setIdusuario($row['idusuario']);
      $this->setDeslogin($row['deslogin']);
      $this->setDessenha($row['dessenha']);
      $this->setDtcadastro(new DateTime($row['dtcadastro']));
    }
  }

  public static function getById($id){
    $sql = new Sql("localhost","dbphp7");
    return $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID",array(":ID"=>$id));
  }
  public static function getByLogin($login){
    $sql = new Sql("localhost","dbphp7");
    return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :LOGIN ORDER BY deslogin",array(":LOGIN"=>"%".$login."%"));
  }

  public static function getList(){
    $sql = new Sql("localhost","dbphp7");
    return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
  }

  public function login($login,$password){
    $sql = new Sql("localhost","dbphp7");
    $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD",array(
      ":LOGIN"=>$login,
      ":PASSWORD"=>$password
    ));
    $resultArray = json_decode($result,true);
    if($resultArray){
      $row = $resultArray[0];
      $this->setIdusuario($row['idusuario']);
      $this->setDeslogin($row['deslogin']);
      $this->setDessenha($row['dessenha']);
      $this->setDtcadastro(new DateTime($row['dtcadastro']));
    } else{
      throw new Exception(("Login ou senha inválidos!"));
    }
  }

  public function __toString(){
    $data = array(
      "idusuario"=>$this->getIdusuario(),
      "deslogin"=>$this->getDeslogin(),
      "senha"=>$this->getDessenha(),
      "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
    );
    return json_encode($data);
  }
}
?>