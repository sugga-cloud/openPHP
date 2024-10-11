<?php
list("path"=>$url)=parse_url($_SERVER['REQUEST_URI']);
if(strpos($url,".php")){
    header("Restricted",true,403);
    die();
}