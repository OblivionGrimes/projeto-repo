<?php

namespace src\Core;

class Router
{
    private $basePath;
    private $notFoundPath;

    public function __construct()
    {
        $this->basePath = dirname(__DIR__, 2) . '/routes/dashboard/';
        
        $this->notFoundPath = dirname(__DIR__, 2) . '/routes/dashboard/404.php';
    }

    /**
     * Recebe a URL suja e retorna o caminho físico do arquivo PHP a ser incluído
     */

    public function getFileFromUrl($url)
    {
        $url = trim($url, '/');

        if (str_starts_with($url, 'd/manage/')) {
            $url = substr($url, strlen('d/manage/'));
        }

        if ($url === '') {
            return dirname(__DIR__, 2) . '/routes/public/login.php';
        }

        $dashPath = dirname(__DIR__, 2) . '/routes/dashboard/' . $url . '.php';
        if (file_exists($dashPath)) {
            return $dashPath;
        }

        $publicPath = dirname(__DIR__, 2) . '/routes/public/' . $url . '.php';
        if (file_exists($publicPath)) {
            return $publicPath;
        }

        $dirIndex = dirname(__DIR__, 2) . '/routes/dashboard/' . $url . '/index.php';
        if (file_exists($dirIndex)) {
            return $dirIndex;
        }

        return dirname(__DIR__, 2) . '/routes/dashboard/404.php';
    }

    public function getControllerFromView($viewPath)
    {
        $basePath       = dirname(__DIR__, 2);
        $controllersPath = $basePath . '/src/Controllers';

        $relative = str_replace([$basePath . '/routes/public/', $basePath . '/routes/dashboard/manage/'], '', $viewPath);

        if (str_contains($viewPath, '/routes/public/')) {
            $candidate = $controllersPath . '/Public/' . $this->toControllerName($relative);
        } else {
            $candidate = $controllersPath . '/Dashboard/' . $this->toControllerName($relative);
        }

        return file_exists($candidate) ? $candidate : null;
    }

    // Converte "home/index.php" → "Home/IndexController.php"
    private function toControllerName($relative)
    {
        $parts    = explode('/', $relative);
        $file     = array_pop($parts);                          // "index.php"
        $name     = ucfirst(str_replace('.php', '', $file));   // "Index"
        $parts    = array_map('ucfirst', $parts);               // ["Home"]
        $parts[]  = $name . 'Controller.php';                   // ["Home", "IndexController.php"]

        return implode('/', $parts);
    }

}