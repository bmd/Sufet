<?php

use Sufet\Sufet;

/**
 * Class SufetTest
 * @package Tests
 */
class SufetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function expectedNegotiatorDataProvider()
    {
        return [
            ['accept', 'application/json', \Sufet\Negotiators\AcceptNegotiator::class],
            ['accept-charset', 'utf-8', \Sufet\Negotiators\AcceptCharsetNegotiator::class],
            ['accept-encoding', 'gzip', \Sufet\Negotiators\AcceptEncodingNegotiator::class],
            ['accept-language', 'en-us', \Sufet\Negotiators\AcceptLanguageNegotiator::class],
        ];
    }

    /**
     * @return array
     */
    public function badHeaderDataProvider()
    {
        return [
            ['accept-potato'],
            ['Location'],
        ];
    }

    /**
     * @test
     * @dataProvider expectedNegotiatorDataProvider
     *
     * @param $headerName
     * @param $headerValue
     * @param $expectedClass
     */
    public function it_should_instantiate_negotiators_based_on_header_names($headerName, $headerValue, $expectedClass)
    {
        $mediaNegotiator = Sufet::makeNegotiator($headerName, $headerValue);
        $this->assertInstanceOf($expectedClass, $mediaNegotiator);
    }

    /**
     * @test
     * @dataProvider badHeaderDataProvider
     * @expectedException DomainException
     *
     * @param $badHeader
     */
    public function it_should_throw_execption_when_header_name_is_not_mapped_to_negotiator($badHeader)
    {
        Sufet::makeNegotiator($badHeader, 'potato');
    }
}
