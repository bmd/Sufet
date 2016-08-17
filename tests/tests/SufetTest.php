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
        $this->assertInstanceOf('Sufet\Negotiators\Media', $mediaNegotiator);

        $charsetNegotiator = Sufet::makeNegotiator('accept-charset', 'utf-8');
        $this->assertInstanceOf('Sufet\Negotiators\Charset', $charsetNegotiator);

        $encodingNegotiator = Sufet::makeNegotiator('accept-encoding', 'gzip');
        $this->assertInstanceOf('Sufet\Negotiators\Encoding', $encodingNegotiator);

        $languageNegotiator = Sufet::makeNegotiator('accept-language', 'en-us');
        $this->assertInstanceOf('Sufet\Negotiators\Language', $languageNegotiator);
    }

    public function testInvalidHeaderRaisesException()
    {
        $badHeader = 'accept-potato';
        $this->setExpectedException('DomainException', "Can't negotiate based on header '$badHeader'");

        Sufet::makeNegotiator($badHeader, 'potato');
    }
}
