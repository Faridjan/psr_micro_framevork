<?php

namespace Farid\Framework\Http;


class Request
{
    public function getQueryParams(): array
    {
        return $_GET;
    }

    public function getParsetBody()
    {
        return $_POST ?: null;
    }
}