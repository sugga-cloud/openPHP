<?php

namespace framework\utility;
require_once("config.php");

function dd($data)
{
    var_dump($data);
    die();
}

class Template
{
    protected $vars = [];
    protected $viewsPath;
    protected $cachePath;

    public function __construct()
    {
        $this->viewsPath = __DIR__ . "/../..".$_ENV["VIEWS_DIR"];
        $this->cachePath = rtrim(__DIR__ . "/../cache", '/');
    }

    public function assign($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function view($view, $data = [])
    {
        if ($data) {
            foreach ($data as $k => $v):
                $this->assign($k, $v);
            endforeach;
        }
    
        echo $this->render($view);
    }

    public function render($view)
    {
        $filePath = $this->viewsPath  . $view . '.open.php';
        $cacheFile = $this->cachePath . '\\' . md5($view) . '.php';

        // Compile template if cache does not exist
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
        $this->compile($filePath, $cacheFile);
        if ($this->vars) {
            extract($this->vars);
        }
        
        
        return rtrim(require($cacheFile),"1");
    
    }

    protected function compile($filePath, $cacheFile)
    {
        $content = file_get_contents($filePath);

        // Replace Blade syntax with PHP
        
        $content = str_replace('<?php require_once("../framework/utility/access.php"); ?>','',$content);
        $content = preg_replace('/@asset\s*\("(.+?)"\)/', '<?php $this->asset("$1"); ?> ', $content);
        $content = preg_replace('/{{\s*(.+?)\s*}}/', '<?php echo htmlspecialchars($1, ENT_QUOTES, "UTF-8"); ?>', $content);
        $content = preg_replace('/@if\s*\((.+?)\)/', '<?php if($1): ?>', $content);
        $content = preg_replace('/@else/', '<?php else: ?>', $content);
        $content = preg_replace('/@endif/', '<?php endif; ?>', $content);
        $content = preg_replace('/@foreach\s*\((.+?)\)/', '<?php foreach($1): ?>', $content);
        $content = preg_replace('/@endforeach/', '<?php endforeach; ?>', $content);
        $content = preg_replace('/@include\s*\("(.+?)"\)/', '<?php include $this->viewsPath . "/partials/$1"; ?>', $content);
        $content = preg_replace('/@layout\s*\("(.+?)"\)/', '<?php $this->layout("$1", ob_get_clean()); ?>', $content);

        file_put_contents($cacheFile, $content);
    }

    public function asset($path){
        echo "\"".$_ENV["BASE_URL"].$_ENV["STATIC_DIR"]."/$path"."\"";
    }

    public function layout($layout, $content)
    {
        $this->assign('content', $content);
        return $this->render('layouts/' . $layout);
    }
}
