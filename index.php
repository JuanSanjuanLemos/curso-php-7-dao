<?php
require_once("config.php");
// $root = new Usuario();
// $root->loadById(7);
// echo $root;
// echo Usuario::getList();
// echo Usuario::getById(1);
// echo Usuario::getByLogin("Pedro");
// $usuario = new Usuario();
// $usuario->login("bug","123");
// echo $usuario;

// $aluno = new Usuario("alunonovo","@luno");
// $aluno->insert();

// $aluno->update("trem","foi");
// echo $aluno;

$root = new Usuario();
$root->loadById(7);
echo $root;
$root->delete();
?>