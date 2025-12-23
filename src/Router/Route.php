<?php
namespace App\Router;
class Route {

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable){
        $this->path = trim($path, '/');  // On retire les / inutils
        $this->callable = $callable;
    }

    /**
        * Permettra de capturer l'url avec les paramètre
        * get('/posts/:slug-:id') par exemple
    **/
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;  // On sauvegarde les paramètre dans l'instance pour plus tard
        return true;
    }

    public function call() {
        // Passe les paramètres capturés à la fonction si c'est un callable
        if(is_callable($this->callable)){
            return call_user_func_array($this->callable, $this->matches);
        } elseif(is_string($this->callable) && strpos($this->callable, '@') !== false) {
            // Support "Controller@method"
            list($controller, $method) = explode('@', $this->callable);
            $controllerClass = "App\\Controllers\\$controller";

            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller $controllerClass not found");
            }

            $obj = new $controllerClass();

            if (!method_exists($obj, $method)) {
                throw new \Exception("Method $method not found in $controllerClass");
            }

            return call_user_func_array([$obj, $method], $this->matches);
        }
        throw new \Exception("Callable not valid");
    }


}