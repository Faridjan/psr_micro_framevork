<?php


namespace Farid\App\Http\Action;

use Laminas\Diactoros\Response\HtmlResponse;

class AboutAction
{
    public function __invoke()
    {
        return new HtmlResponse('<h2>About page</h2>');
    }
}