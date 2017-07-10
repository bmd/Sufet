<?php

use Sufet\Middleware\NegotiatorMiddleware;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class NegotiatorMiddlewareTest
 */
class NegotiatorMiddlewareTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_construct_charset_middleware()
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
     * @test
     */
    public function it_should_construct_encoding_middleware()
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
     * @test
     */
    public function it_should_construct_language_middleware()
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
     * @test
     */
    public function it_should_construct_content_type_middleware()
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