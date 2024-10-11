<?php

namespace framework\Error;

class Error{
    public $error = "";
    function InvalidRequest(){
        $this->error = "Invalid Request";
        echo "$this->error";
    }

    function MethodDoesNotExist(){
        $this->error = "Method Doesn't exist in the Controller";
        echo "$this->error";    
    }
}