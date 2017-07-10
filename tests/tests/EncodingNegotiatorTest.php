<?php

use Sufet\Negotiators\AcceptEncodingNegotiator;

/**
 * Class EncodingNegotiatorTest
 */
class EncodingNegotiatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_construct_the_encoding_negotiator()
    {
        $this->assertInstanceOf(AcceptEncodingNegotiator::class, new AcceptEncodingNegotiator('*'));
    }

    /**
     * @test
     */
    public function it_should_accept_any_type_with_wildcard_header()
    {
        $negotiator = new AcceptEncodingNegotiator('*');
        $this->assertTrue($negotiator->best()->isWildCardType());

        foreach (['gzip', 'identity', 'br'] as $type) {
            $this->assertTrue($negotiator->willAccept($type));
        }
    }

    /**
     * @test
     */
    public function it_should_parse_parameters_associated_with_wildcard_header()
    {
        $negotiator = new AcceptEncodingNegotiator('*;q=0.7;foo=bar');

        $this->assertEquals('0.7', $negotiator->best()->q());
        $this->assertEquals('bar', $negotiator->best()->params()->get('foo'));
        $this->assertTrue($negotiator->wants('*'));
        $this->assertFalse($negotiator->wants('gzip'));
        $this->assertTrue($negotiator->willAccept('gzip'));
    }

    /**
     * @test
     */
    public function it_should_negotiate_against_simple_header()
    {
        $negotiator = new AcceptEncodingNegotiator('compress');
        $this->assertFalse($negotiator->willAccept('*'));
        $this->assertTrue($negotiator->wants('compress'));
        $this->assertTrue($negotiator->willAccept('compress'));
        $this->assertEquals(1.0, $negotiator->best()->q());
    }

    /**
     * @group Encoding
     * @group Negotiators
     * @test
     */
    public function it_should_handle_simple_encodings_with_parameters()
    {
        $negotiator = new AcceptEncodingNegotiator('compress;level=2');
        $this->assertFalse($negotiator->willAccept('*'));
        $this->assertTrue($negotiator->wants('compress'));
        $this->assertTrue($negotiator->willAccept('compress'));
        $this->assertEquals(1.0, $negotiator->best()->q());
        $this->assertEquals(2, $negotiator->best()->param('level'));
    }

    /**
     * @group Encoding
     * @group Negotiators
     * @test
     */
    public function it_should_prefer_headers_by_q_value()
    {
        $negotiator = new AcceptEncodingNegotiator('*;q=0.8,compress;level=2;q=1.0,identity;q=0.9');
        $this->assertTrue($negotiator->wants('compress'));
        $this->assertTrue($negotiator->prefers('compress', 'identity'));
        $this->assertTrue($negotiator->prefers('identity', '*'));
        $this->assertFalse($negotiator->prefers('potato', 'compress'));
        $this->assertEquals('compress', $negotiator->best()->getBaseType());
        $this->assertEquals('2', $negotiator->best()->params()->get('level'));
    }
}