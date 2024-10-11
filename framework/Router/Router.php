<?php

use framework\Error\Error;
use framework\utility\utility;
class Router extends utility
{
    protected $paths = ["GET" => [], "POST" => []];

    function add($method, $path, $handler)
    {
        switch ($method) {
            case "GET":
                $this->paths["GET"][$path] = $handler;
                break;
            case "POST":
                $this->paths["POST"][$path] = $handler;
                break;
            default:
                echo "Something went wrong";
        }
    }

    function get($path, $handler)
    {
        $this->add("GET", $path, $handler);
    }

    function post($path, $handler)
    {
        $this->add("POST", $path, $handler);
    }

    function active()
    {
        $url = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];
        $url = parse_url($url);
        if ($this->path_exist($url['path'], $method)) {
            $handler = $this->paths[$method][$url['path']];
            if (is_array($handler)) {
                if (!method_exists($handler[0], $handler[1])) {
                    return (new Error())->MethodDoesNotExist();
                }
                return (new $handler[0])->{$handler[1]}(array_merge($_REQUEST,$_FILES));
            } else {
                return $handler($_REQUEST);
            }
        } else {
            return (new Error())->InvalidRequest();
        }
    }

    function path_exist($url, $method)
    {
        return array_key_exists($url, $this->paths[$method]);
    }
}