<?php

class Route
{
    public $url;
    public $controller;
    public $authorization;
    public $name;
    public $menu;

    public function __construct($url, $controller, $authorization, $name, $menu)
    {
        $this->url = $url;
        $this->controller = $controller;
        $this->authorization = $authorization;
        $this->name = $name;
        $this->menu = $menu;
    }

    public static function serve($routes)
    {
        RouteHook::fire('before_request', compact('routes'));

        $request_method = strtolower($_SERVER['REQUEST_METHOD']);
        $path_info = '/';

        if (! empty($_SERVER['PATH_INFO'])) {
            $path_info = $_SERVER['PATH_INFO'];
        } elseif (! empty($_SERVER['ORIG_PATH_INFO']) && $_SERVER['ORIG_PATH_INFO'] !== '/index.php') {
            $path_info = $_SERVER['ORIG_PATH_INFO'];
        } else {
            if (! empty($_SERVER['REQUEST_URI'])) {
                $path_info = (strpos($_SERVER['REQUEST_URI'], '?') > 0) ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI'];
            }
        }
        
        $discovered_handler = null;
        $regex_matches = array();

        if (isset($routes[$path_info])) {
            $discovered_handler = $routes[$path_info];
        } elseif ($routes) {
            $tokens = array(
                ':string' => '([a-zA-Z]+)',
                ':number' => '([0-9]+)',
                ':alpha'  => '([a-zA-Z0-9-_]+)'
            );
            foreach ($routes as $pattern => $handler_name) {
                $pattern = strtr($pattern, $tokens);
                if (preg_match('#^/?' . $pattern . '/?$#', $path_info, $matches)) {
                    $discovered_handler = $handler_name;
                    $regex_matches = $matches;
                    break;
                }
            }
        }

        $result = null;
        $handler_instance = null;

        if ($discovered_handler) {
            if (is_string($discovered_handler)) {
                $handler_instance = new $discovered_handler();
            } elseif (is_callable($discovered_handler)) {
                $handler_instance = $discovered_handler();
            }
        }

        if ($handler_instance) {
            unset($regex_matches[0]);

            if (self::is_xhr_request() && method_exists($handler_instance, $request_method . '_xhr')) {
                header('Content-type: application/json');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
                header('Cache-Control: no-store, no-cache, must-revalidate');
                header('Cache-Control: post-check=0, pre-check=0', false);
                header('Pragma: no-cache');
                $request_method .= '_xhr';
            }

            if (method_exists($handler_instance, $request_method)) {
                RouteHook::fire('before_handler', compact('routes', 'discovered_handler', 'request_method', 'regex_matches'));
                $result = call_user_func_array(array($handler_instance, $request_method), $regex_matches);
                RouteHook::fire('after_handler', compact('routes', 'discovered_handler', 'request_method', 'regex_matches', 'result'));
            } else {
                RouteHook::fire('404', compact('routes', 'discovered_handler', 'request_method', 'regex_matches'));
            }
        } else {
            RouteHook::fire('404', compact('routes', 'discovered_handler', 'request_method', 'regex_matches'));
        }

        RouteHook::fire('after_request', compact('routes', 'discovered_handler', 'request_method', 'regex_matches', 'result'));
    }

    private static function is_xhr_request()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}

class RouteHook
{
    private static $instance;

    private $hooks = array();

    private function __construct() {}
    private function __clone() {}

    public static function add($hook_name, $fn)
    {
        $instance = self::get_instance();
        $instance->hooks[$hook_name][] = $fn;
    }

    public static function fire($hook_name, $params = null)
    {
        $instance = self::get_instance();
        if (isset($instance->hooks[$hook_name])) {
            foreach ($instance->hooks[$hook_name] as $fn) {
                call_user_func_array($fn, array(&$params));
            }
        }
    }

    public static function get_instance()
    {
        if (empty(self::$instance)) {
            self::$instance = new RouteHook();
        }
        return self::$instance;
    }
}

class Routes {

    private static $instance = NULL;
    public $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function Add($obj)
    {
        $this->routes[] = $obj;
    }

    public function getAll()
    {
        return $this->routes;
    }

    public function getRoutes()
    {
        $ret = [];
        foreach($this->routes as $route) {
            $ret[$route->url] = $route->controller;
        }
        return $ret;
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Routes();
        }
        return self::$instance;
    }

    public function getMenu()
    {
        $ret = [];
        foreach($this->routes as $route) {
            if($route->menu) {
                $ret[$route->name] = $route->url;
            }
        }
        return $ret;
    }

    public function getCredential($class)
    {
        $ret = null;

        foreach($this->routes as $route) {
            if(strtolower($route->controller) == strtolower($class)) {
                $ret = $route->authorization;
            }
        }

        return $ret;
    }

    public function Load() {

        $this->routes = null;

        $this->Add(new Route("/", "Home", ["Amministratore", "Normale", "Visitatore"], "Home", true));
        $this->Add(new Route("/notauthorized", "NotAuthorized", [], "Not Authorized", false));

        $this->Add(new Route("/todo", "Todo", ["Amministratore", "Normale"], "Todo", true));
        $this->Add(new Route("/todoadd", "TodoAdd", ["Amministratore", "Normale"], "Todoadd", false));
        $this->Add(new Route("/todo/delete/:number", "TodoDelete", ["Amministratore", "Normale"], "TodoDelete", false));
        $this->Add(new Route("/todo/modify/:number", "TodoModify", ["Amministratore", "Normale"], "TodoModify", false));

        $this->Add(new Route("/utente", "Utente", ["Amministratore"], "Utenti", true));
        $this->Add(new Route("/utente/delete/:number", "UtenteDelete", ["Amministratore"], "Utente delete", false));
        $this->Add(new Route("/utente/modify/:number", "UtenteModify", ["Amministratore"], "Utente modify", false));

        $this->Add(new Route("/login", "Login", [], "Login", false));
        $this->Add(new Route("/logout", "Logout", ["Amministratore", "Normale", "Visitatore"], "Logout", true));

        return $this;
    }

}
