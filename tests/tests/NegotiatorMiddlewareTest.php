<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Tests
 * @author     Brendan Maione-Downing <b.maionedowning@gmail.com>
 * @copyright  2016
 * @license    MIT
 * @link       https://github.com/bmd/Sufet
 */

use Sufet\Middleware\NegotiatorMiddleware;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class NegotiatorMiddlewareTest
 */
class NegotiatorMiddlewareTest extends PHPUnit_Framework_TestCase
{
    /**
     * @group Middleware
     */
    public function testConstructsCharsetMiddleware()
    {
        /** @var \Zend\Diactoros\ServerRequest $request */
        $request = ServerRequestFactory::fromGlobals(['HTTP_ACCEPT_CHARSET' => 'utf-8']);
        $response = new Response();
        $middleware = new NegotiatorMiddleware('accept-charset');

        $request = $middleware($request, $response, function ($request, $response) {
            return $request;
        });

        $this->assertInstanceOf('\\Sufet\\Negotiators\\AcceptCharsetNegotiator', $request->getAttribute('acceptCharset'));
    }

    /**
     * @group Middleware
     */
    public function testConstructsEncodingMiddleware()
    {
        /** @var \Zend\Diactoros\ServerRequest $request */
        $request = ServerRequestFactory::fromGlobals(['HTTP_ACCEPT_ENCODING' => 'gzip']);
        $response = new Response();
        $middleware = new NegotiatorMiddleware('accept-encoding');

        $request = $middleware($request, $response, function ($request, $response) {
            return $request;
        });

        $this->assertInstanceOf('\\Sufet\\Negotiators\\AcceptEncodingNegotiator', $request->getAttribute('acceptEncoding'));
    }

    /**
     * @group Middleware
     */
    public function testConstructsLanguageMiddleware()
    {
        /** @var \Zend\Diactoros\ServerRequest $request */
        $request = ServerRequestFactory::fromGlobals(['HTTP_ACCEPT_LANGUAGE' => 'en-us,en-*;q=0.9']);
        $response = new Response();
        $middleware = new NegotiatorMiddleware('accept-language');

        $request = $middleware($request, $response, function ($request, $response) {
            return $request;
        });

        $this->assertInstanceOf('\\Sufet\\Negotiators\\AcceptLanguageNegotiator', $request->getAttribute('acceptLanguage'));
    }

    /**
     * @group Middleware
     */
    public function testConstructsContentTypeMiddleware()
    {
        /** @var \Zend\Diactoros\ServerRequest $request */
        $request = ServerRequestFactory::fromGlobals(['HTTP_ACCEPT' => 'application/json']);
        $response = new Response();
        $middleware = new NegotiatorMiddleware('accept');

        $request = $middleware($request, $response, function ($request, $response) {
            return $request;
        });

        $this->assertInstanceOf('\\Sufet\\Negotiators\\AcceptNegotiator', $request->getAttribute('accept'));
    }
}