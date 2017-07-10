<?php

use Sufet\Negotiators\AcceptCharsetNegotiator;

class AcceptCharsetNegotiatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_instantiate_a_charset_negotiator()
    {
        $negotiator = new AcceptCharsetNegotiator('utf-8');
        $this->assertInstanceOf(AcceptCharsetNegotiator::class, $negotiator);
    }

    /**
     * @test
     */
    public function it_should_accept_anything_with_wildcard_header()
    {
        $negotiator = new AcceptCharsetNegotiator('*');
        $this->assertTrue($negotiator->best()->isWildCardType());
        $this->assertEquals('1.0', $negotiator->best()->q());
        $this->assertTrue($negotiator->willAccept('potato'));
        $this->assertTrue($negotiator->willAccept('ISO-8859-1'));
    }

    /**
     * @test
     */
    public function it_should_correctly_handle_empty_header()
    {
        $negotiator = new AcceptCharsetNegotiator('');

        $this->assertTrue($negotiator->willAccept('*'));
        $this->assertTrue($negotiator->willAccept('ISO-8859-1'));
    }
}
