<?php
require_once("config.php");
$root = new Usuario();
$root->loadById(7);
echo $root;

?>