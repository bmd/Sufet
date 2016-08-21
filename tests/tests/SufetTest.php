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
