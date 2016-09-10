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

use Sufet\Negotiators\AcceptCharsetNegotiator;

class AcceptCharsetNegotiatorTest extends PHPUnit_Framework_TestCase
{

    protected function getNegotiator($charset)
    {
        return new AcceptCharsetNegotiator($charset);
    }

    /**
     * @group Charset
     */
    public function testNegotiatorIsInstantiated()
    {
        $negotiator = $this->getNegotiator('utf-8');
        $this->assertInstanceOf("\\Sufet\\Negotiators\\AcceptCharsetNegotiator", $negotiator);
    }

    public function testWildCardCharsetHeader()
    {
        $negotiator = $this->getNegotiator('*');
        $this->assertTrue($negotiator->best()->isWildCardType());
        $this->assertEquals('1.0', $negotiator->best()->q());
        $this->assertTrue($negotiator->willAccept('potato'));
        $this->assertTrue($negotiator->willAccept('ISO-8859-1'));
    }

    public function testEmptyCharsetHeader()
    {
        $negotiator = $this->getNegotiator('');
        $this->assertTrue($negotiator->willAccept('*'));
        $this->assertTrue($negotiator->willAccept('ISO-8859-1'));
    }
}
