<?php
spl_autoload_register(function ($class){
    $file_path = __DIR__."/../".str_replace("\\","/",$class).".php";
    require_once($file_path);
});