<?php

if (!function_exists('renderView')) {
    function renderView(string $viewName, array $params = []): string
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params);
        require __DIR__ . "/$viewName.php";
        return ob_get_clean();
    }
}

if (!function_exists('startPage')) {
    function startPage(): void
    {
        ob_start();
        ob_implicit_flush(false);
    }
}

if (!function_exists('endPage')) {
    function endPage(): void
    {
        $content = ob_get_clean();
        $result = renderView('layout', compact('content'));
        send($result);
    }
}

if (!function_exists('db')) {
    function db(): PDO
    {
        static $db = null;
        if ($db === null) {
            $config = (include "config.php")['db'];
            $db = new PDO($config['dsn'], $config['username'], $config['password'], [
                PDO::ATTR_PERSISTENT => true,
            ]);
        }

        return $db;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url): void
    {
        $host = $_SERVER['HTTP_HOST'];
        header("Location: http://$host/$url");
    }
}

if (!function_exists('send')) {
    function send(string $data, int $status = 200): void
    {
        ob_start();
        header($_SERVER["SERVER_PROTOCOL"]." $status Ok");
        header('Content-type: text/html; charset=utf-8');
        echo $data;
        ob_end_flush();
    }
}

if (!function_exists('sample')) {
    function sample()
    {
    }
}