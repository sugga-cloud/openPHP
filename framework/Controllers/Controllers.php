<?php

namespace framework\Controllers;
use framework\utility\Template;
use framework\DataBase\SQLite as db;

class Controllers extends Template{
    function index($req){             
        return $this->view("welcome");
    }


}