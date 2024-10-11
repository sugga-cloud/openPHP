<?php

require_once("framework/autoload.php");
require_once("framework/Router/Router.php");
$router = new Router;
require_once("routes.php");

echo $router->active();