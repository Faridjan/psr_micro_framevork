<?php


namespace Farid\Framework\Http\Router\Route;

use Farid\Framework\Http\Router\Result;
use \Psr\Http\Message\ServerRequestInterface;

class RegexpRoute implements Route
{
    public $name;
    public $pattern;
    public $handler;
    public $methods;
    public $token;

    public function __construct($name, $pattern, $handler, array $methods, array $token = [])
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->handler = $handler;
        $this->methods = $methods;
        $this->token = $token;
    }

    public function match(ServerRequestInterface $request): ?Result
    {
        if ($this->methods && !\in_array($request->getMethod(), $this->methods, true)) return null;

        $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) {
            $argument = $matches[1];
            $replace = $this->tokens[$argument] ?? '[^}]+';
            return '(?P<' . $argument . '>' . $replace . ')';
        }, $this->pattern);

        $path = $request->getUri()->getPath();
        if (preg_match('~^' . $pattern . '$~i', $path, $matches)) {
            return new Result(
                $this->name,
                $this->handler,
                array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY)
            );
        }

        return null;
    }

    public function generate($name, array $params = []): ?string
    {
        $arguments = array_filter($params);

        if ($name !== $this->name) {
            return null;
        }

        $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use (&$arguments) {
            $argument = $matches[1];
            if (!array_key_exists($argument, $arguments)) {
                throw new \InvalidArgumentException('Missing parameter "' . $argument . '"');
            }
            return $arguments[$argument];
        }, $this->pattern);

        return $url;
    }
}