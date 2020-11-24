<?php


use Farid\App\Http\Middleware\BasicAuthMiddleware;
use Farid\App\Http\Middleware\CredentialsMiddleware;
use Farid\App\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Farid\App\Http\Middleware\ProfileMiddleware;
use Farid\Framework\Http\Middleware\DispatchMiddleware;
use Farid\Framework\Http\Middleware\RouteMiddleware;

/** @var Farid\Framework\Http\Application $app */

$app->pipe(ErrorHandlerMiddleware::class);
$app->pipe(ProfileMiddleware::class);
$app->pipe(CredentialsMiddleware::class);
$app->pipe(RouteMiddleware::class); // Определение маршрута
$app->pipe('cabinet', BasicAuthMiddleware::class);
$app->pipe(DispatchMiddleware::class); // Выполнение экшина