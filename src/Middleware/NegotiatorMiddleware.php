<?php
namespace Sufet\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sufet\Sufet;

/**
 * Class NegotiatorMiddleware
 * @package Sufet\Middleware
 */
class NegotiatorMiddleware
{
    /**
     * The name of the parameter to set the negotiator as on the request object.
     *
     * Once the negotiator is set, subsequent middlewares or controllers can
     * access the \Sufet\Negotiator instance on the request as
     * `$request->$attributeName`. If an override is not provided in the constructor,
     * the attribute name will be inferred from the name of the header being
     * negotiated. This should generally be preferred except in the case where
     * there is the potential for a usage to conflict with another middleware.
     *
     * @var string
     */
    protected $attributeName;

    /**
     * The name of the header to base negotiation on. This contents of this
     * header will be retrieved from the Request object and passed to the
     * negotiator unchanged.
     *
     * @var string
     */
    protected $headerName;

    /**
     * Construct the negotiator middleware.
     *
     * @param  string      $headerName
     * @param  string|null $attributeName (optional)
     */
    public function __construct($headerName, $attributeName = null)
    {
        $this->headerName = $headerName;
        $this->parameterName = $attributeName ?: str_replace('-', '', lcfirst(ucwords($headerName, '-')));
    }

    /**
     * Magic __invoke() method to improve middleware behavior.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request
     * @param  \Psr\Http\Message\ResponseInterface      $response
     * @param  Callable                                 $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Callable $next)
    {
        $request = $request->withAttribute(
            $this->attributeName,
            Sufet::makeNegotiator($this->headerName, $request->getHeader($this->headerName))
        );

        return $next($request, $response);
    }
}
