<?php
class Usuario
{
  private $idusuario;
  private $deslogin;
  private $dessenha;
  private $dtcadastro;

  public function getIdusuario()
  {
    return $this->idusuario;
  }
  public function setIdusuario($idusuario)
  {
    $this->idusuario = $idusuario;
  }
  public function getDeslogin()
  {
    return $this->deslogin;
  }
  public function setDeslogin($deslogin)
  {
    $this->deslogin = $deslogin;
  }
  public function getDessenha()
  {
    return $this->dessenha;
  }
  public function setDessenha($dessenha)
  {
    $this->dessenha = $dessenha;
  }
  public function getDtcadastro()
  {
    return $this->dtcadastro;
  }
  public function setDtcadastro($dtcadastro)
  {
    $this->dtcadastro = $dtcadastro;
  }

  public function __construct($login="",$password="")
  {
    $this->setDeslogin($login);
    $this->setDessenha($password);
  }

  public function loadById($id)
  {
    $sql = new Sql("localhost", "dbphp7");
    $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
      ":ID" => $id
    ));
    $resultArray = json_decode($result, true);
    if ($resultArray > 0) {
      $row = $resultArray[0];
      $this->setData($row);
    }
  }

  public static function getById($id)
  {
    $sql = new Sql("localhost", "dbphp7");
    return $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID" => $id));
  }
  public static function getByLogin($login)
  {
    $sql = new Sql("localhost", "dbphp7");
    return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :LOGIN ORDER BY deslogin", array(":LOGIN" => "%" . $login . "%"));
  }

  public static function getList()
  {
    $sql = new Sql("localhost", "dbphp7");
    return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
  }

  public function login($login, $password)
  {
    $sql = new Sql("localhost", "dbphp7");
    $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
      ":LOGIN" => $login,
      ":PASSWORD" => $password
    ));
    $resultArray = json_decode($result, true);
    if ($resultArray) {
      $row = $resultArray[0];
      $this->setData($row);
    } else {
      throw new Exception(("Login ou senha inválidos!"));
    }
  }



  public function setData($data)
  {
    $this->setIdusuario($data['idusuario']);
    $this->setDeslogin($data['deslogin']);
    $this->setDessenha($data['dessenha']);
    $this->setDtcadastro(new DateTime($data['dtcadastro']));
  }

  public function insert()
  {
    $sql = new Sql("localhost", "dbphp7");
    $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
      ":LOGIN" => $this->getDeslogin(),
      ":PASSWORD" => $this->getDessenha()
    ));
    $resultsArray = json_decode($results, true);
    if ($resultsArray) {
      $row = $resultsArray[0];
      $this->setData($row);
    }
    else{
      throw new Exception(("Erro ao inserir os dados!"));
    }
  }

  public function update($login,$password){
    $sql = new Sql("localhost","dbphp7");
    $id = $this->getIdusuario();
    $sql->query(("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID"),
    array(
      ":ID"=>$id,
      ":LOGIN"=>$login,
      ":PASSWORD"=>$password
    ));
    $this->setDeslogin($login);
    $this->setDessenha($password);
  }

  public function delete(){
    $sql = new Sql("localhost","dbphp7");
    $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$this->getIdusuario()));
    $this->setIdusuario(0);
    $this->setDeslogin("");
    $this->setDessenha("");
    $this->setDtcadastro(new DateTime());
  }

  public function __toString()
  {
    $data = array(
      "idusuario" => $this->getIdusuario(),
      "deslogin" => $this->getDeslogin(),
      "senha" => $this->getDessenha(),
      "dtcadastro" => $this->getDtcadastro()->format("d/m/Y H:i:s")
    );
    return json_encode($data);
  }
}
