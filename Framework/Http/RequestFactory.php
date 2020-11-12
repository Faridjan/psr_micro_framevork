<?php


namespace Farid\Framework\Http;

use Farid\Framework\Http\Request;


class RequestFactory
{
    public static function fromGlobals(array $query = null, array $body = null): Request
    {
        return ((new Request())
            ->withQueryParams($query ?: $_GET)
            ->withParsedBody($body ?: $_POST));
    }
}