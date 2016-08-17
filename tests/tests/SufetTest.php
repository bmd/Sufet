<?php

use Sufet\Sufet;

/**
 * Class SufetTest
 * @package Tests
 */
class SufetTest extends PHPUnit_Framework_TestCase
{

    public function testSufetCreatesNegotiators()
    {
        $mediaNegotiator = Sufet::makeNegotiator('accept', 'application/json');
        $this->assertInstanceOf('Sufet\Negotiators\AcceptNegotiator', $mediaNegotiator);

        $charsetNegotiator = Sufet::makeNegotiator('accept-charset', 'utf-8');
        $this->assertInstanceOf('Sufet\Negotiators\AcceptCharsetNegotiator', $charsetNegotiator);

        $encodingNegotiator = Sufet::makeNegotiator('accept-encoding', 'gzip');
        $this->assertInstanceOf('Sufet\Negotiators\AcceptEncodingNegotiator', $encodingNegotiator);

        $languageNegotiator = Sufet::makeNegotiator('accept-language', 'en-us');
        $this->assertInstanceOf('Sufet\Negotiators\AcceptLanguageNegotiator', $languageNegotiator);
    }

    public function testInvalidHeaderRaisesException()
    {
        $badHeader = 'accept-potato';
        $this->setExpectedException('DomainException', "Can't negotiate based on header '$badHeader'");

        Sufet::makeNegotiator($badHeader, 'potato');
    }
}
