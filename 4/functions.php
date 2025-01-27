<?php

use JetBrains\PhpStorm\NoReturn;

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
        sendHtml($result);
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
    #[NoReturn] function send(string $data = '', int $status = 200): void
    {
        ob_start();
        http_response_code($status);
        header('Content-type: application/json');
        echo $data;
        ob_end_flush();
        exit();
    }
}

if (!function_exists('sendHtml')) {
    #[NoReturn] function sendHtml(string $data, int $status = 200): void
    {
        ob_start();
        http_response_code($status);
        header('Content-type: text/html; charset=utf-8');
        echo $data;
        ob_end_flush();
        exit();
    }
}

if (!function_exists('jsonEncode')) {
    /**
     * @throws JsonException
     */
    function jsonEncode(array $value = []): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('jsonDecode')) {
    /**
     * @throws JsonException
     */
    function jsonDecode(string $value = ''): array
    {
        return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
    }
}

if (!function_exists('sample')) {
    function sample()
    {
    }
}