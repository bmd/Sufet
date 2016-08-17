<?php
namespace Sufet\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sufet\Sufet;

/**
 * Class MediaTypeNegotiator
 * @package Sufet\Middleware
 */
class MediaTypeNegotiator
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $request = $request->withAttribute(
            'mediaNegotiator',
            Sufet::makeNegotiator('accept', $request->getHeader('accept'))
        );
        return $next($request, $response);
    }
}