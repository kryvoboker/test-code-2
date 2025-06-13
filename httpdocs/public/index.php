<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Отключаем вывод ошибок на экран
ini_set('display_errors', 0);
// Включаем логирование ошибок
ini_set('log_errors', 1);
// Указываем файл для записи ошибок
ini_set('error_log', __DIR__ . '/error.log');
// Отображаем все типы ошибок
error_reporting(E_ALL);

// Пользовательский обработчик ошибок
set_error_handler(function($errno, $errstr, $errfile, $errline) {
	// Записываем ошибку в файл
	error_log("[$errno] $errstr в $errfile на строке $errline");
	// Дополнительная логика обработки ошибки (если требуется)
});

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());