<?php 

require_once("framework/autoload.php");
require_once("config.php");

use framework\DataBase\SQLite;

$db = new SQLite($_ENV['SQLITE_DB_NAME']);


$db->createTable("blogs",['blog_id INTEGER','title TEXT','url TEXT','content TEXT']);
$db->createTable("comment",['blog_id INTEGER','comment TEXT']);
// $db->table("section_c")->insert(['id'=>12,'name'=>"sazid husain"]);
