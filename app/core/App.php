<?php

class App
{
    public function __construct()
    {
        $segments = $this->parseUrl();
        $controllerName = isset($segments[0]) && $segments[0] !== ''
            ? ucfirst($segments[0])
            : 'Gear';
        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!is_file($controllerFile)) {
            http_response_code(404);
            exit('Page not found.');
        }

        require_once $controllerFile;
        if (!class_exists($controllerName)) {
            http_response_code(404);
            exit('Page not found.');
        }

        $controller = new $controllerName();
        $method = isset($segments[1]) && $segments[1] !== '' ? $segments[1] : 'index';

        if (!method_exists($controller, $method)) {
            http_response_code(404);
            exit('Page not found.');
        }

        $reflection = new ReflectionMethod($controller, $method);
        if (!$reflection->isPublic() || $reflection->isStatic()
            || $reflection->getDeclaringClass()->getName() !== $controllerName) {
            http_response_code(404);
            exit('Page not found.');
        }

        call_user_func_array([$controller, $method], array_slice($segments, 2));
    }

    private function parseUrl()
    {
        if (!isset($_GET['url'])) {
            return [];
        }

        $url = trim((string) $_GET['url'], '/');
        if ($url === '') {
            return [];
        }

        return array_map('rawurldecode', explode('/', filter_var($url, FILTER_SANITIZE_URL)));
    }
}
