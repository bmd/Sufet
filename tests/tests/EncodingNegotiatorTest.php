<?php

/**
 * Class EncodingNegotiatorTest
 */
class EncodingNegotiatorTest extends PHPUnit_Framework_TestCase
{

    public function testCreatesEncodingNegotiator()
    {
        $headerName = 'accept-encoding';
        // simplest test case
        $headerContent = '*';

        $negotiator = \Sufet\Sufet::makeNegotiator($headerName, $headerContent);
        $this->assertInstanceOf("\\Sufet\\Negotiators\\AcceptEncodingNegotiator", $negotiator);
    }

    public function testSimpleEncodingHeader()
    {
        // test a basic wildard
        $negotiator = \Sufet\Sufet::makeNegotiator('accept-encoding', '*');
        $this->assertInstanceOf("\\Sufet\\Entities\\ContentType", $negotiator->best());
        $this->assertEquals($negotiator->best()->type, '*');
        $this->assertTrue($negotiator->willAccept('*'));
        $this->assertFalse($negotiator->best()->isWildCardType());
        // test a basic preference without a Q value
        $simplePreference = 'gzip';
        $simplePreferenceWithQ = 'gzip;q=0.8';
    }

    public function testComplexEncodingHeader()
    {

    }
}