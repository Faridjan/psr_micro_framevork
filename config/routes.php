<?php

use Farid\App\Http\Action\AboutAction;
use Farid\App\Http\Action\Blog\IndexAction;
use Farid\App\Http\Action\Blog\ShowAction;
use Farid\App\Http\Action\CabinetAction;
use Farid\App\Http\Action\HelloAction;

/** @var Farid\Framework\Http\Application $app */

$app->get('home', '/', HelloAction::class);
$app->get('about', '/about', AboutAction::class);
$app->get('cabinet', '/cabinet', CabinetAction::class);
$app->get('blog', '/blog', IndexAction::class);
$app->get('blog_show', '/blog/{id}', ShowAction::class, ['tokens' => ["id" => "\d+"]]);