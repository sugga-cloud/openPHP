<?php

namespace framework;

class Shell {
    public function __construct($args) {
        if (strtolower($args[1]) == 'start') {
            // Start the PHP built-in server
            $command = 'php -S localhost:5500';
            shell_exec($command);
            echo "Server started on localhost:5500\n";
        }
        else if (strtolower($args[1]) == 'migrate') {
            // Migration logic
            require_once(__DIR__."/../models/model.php");
            echo "Migration Done\n";
        }
        else if (strtolower($args[1]) == 'create:controller' && isset($args[2])) {
            $this->createController($args[2]);
        }    
        else if (strtolower($args[1]) == 'create:view' && isset($args[2])) {
            $this->createView($args[2]);
        }
        else {
            echo "Invalid command. Use 'start', 'migrate', 'create:controller <name>', or 'create:view <name>'.\n";
        }
    }

    private function createController($name) {
        $controllerName = ucfirst($name) . 'Controller';
        $controllerPath = __DIR__ . "/../Controllers/" . $controllerName.".php";

        // Check and create controller file
        if (!file_exists($controllerPath)) {
            file_put_contents($controllerPath, "<?php\n
namespace framework\Controllers;
use framework\utility\Template;
\n\n class $controllerName {\n    // Controller methods go here\n}\n");
            echo "Controller file created: $controllerPath\n";
        } else {
            echo "Controller file already exists: $controllerPath\n";
        }
    }

    private function createView($name) {
        $viewName = $name . '.open.php';
        $viewPath = "views/" . $viewName;

        // Check and create view file
        if (!file_exists($viewPath)) {
            file_put_contents($viewPath, "<!-- View for $name -->\n".'<?php require_once("../framework/utility/access.php"); ?>
');
            echo "View file created: $viewPath\n";
        } else {
            echo "View file already exists: $viewPath\n";
        }
    }
}
