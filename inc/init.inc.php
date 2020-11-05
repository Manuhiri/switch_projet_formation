<?php
session_start(); 
//session_start() : se positionne TOUJOURS en haut et en PREMIER avant les traitements php !

//------------------------------------------------
//Connexion à la BDD local host :
$pdo = new PDO('mysql:host=localhost;dbname=switch', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8") );
//var_dump($pdo);

//Connexion à la BDD ligne :
//$pdo = new PDO('mysql:host=manuhirilr908.mysql.db;dbname=manuhirilr908', 'manuhirilr908', 'Taoahere1507', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8") );
//var_dump($pdo);

//------------------------------------------------
//Definition d'une constante :
//url local
define('URL', 'http://localhost/manuhirilr908/');

//url ligne
//define('URL', 'http://switch.manuhiri-anihia.fr/');

//------------------------------------------------
//déclaration de variables :
$content = '';
$error = '';
$errorIns='';
$errorCon='';

//------------------------------------------------
require_once "fonction.inc.php";

?>