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

/**
 * Class EncodingNegotiatorTest
 */
class EncodingNegotiatorTest extends PHPUnit_Framework_TestCase
{

    protected function getNegotiator($str)
    {
        return \Sufet\Sufet::makeNegotiator('accept-encoding', $str);

    }

    public function testCreatesEncodingNegotiator()
    {
        $this->assertInstanceOf("\\Sufet\\Negotiators\\AcceptEncodingNegotiator", $this->getNegotiator('*'));
    }

    public function testWildCardEncodingHeader()
    {
        $negotiator = $this->getNegotiator('*');
        $this->assertTrue($negotiator->best()->isWildCardType());

        foreach (['gzip', 'identity', 'br'] as $type) {
            $this->assertTrue($negotiator->willAccept($type));
        }
    }

    public function testWildCardEncodingHeaderWithParameters()
    {
        $negotiator = $this->getNegotiator('*;q=0.7;foo=bar');

        $this->assertEquals('0.7', $negotiator->best()->params()->q);
        $this->assertEquals('bar', $negotiator->best()->params()->foo);
        $this->assertTrue($negotiator->wants('*'));
        $this->assertFalse($negotiator->wants('gzip'));
        $this->assertTrue($negotiator->willAccept('gzip'));
    }

    public function testSimpleEncodingHeader()
    {
        $negotiator = $this->getNegotiator('compress');
        $this->assertFalse($negotiator->willAccept('*'));
        $this->assertTrue($negotiator->wants('compress'));
        $this->assertTrue($negotiator->willAccept('compress'));
        $this->assertEquals(1.0, $negotiator->best()->q());
    }

    public function testSimpleEncodingHeaderWithParameters()
    {
        $negotiator = $this->getNegotiator('compress;level=2');
        $this->assertFalse($negotiator->willAccept('*'));
        $this->assertTrue($negotiator->wants('compress'));
        $this->assertTrue($negotiator->willAccept('compress'));
        $this->assertEquals(1.0, $negotiator->best()->q());
        $this->assertEquals(2, $negotiator->best()->params()->level);
    }

    public function testPrefersBehavior()
    {
        $negotiator = $this->getNegotiator('*;q=0.8,compress;level=2;q=1.0,identity;q=0.9');
        $this->assertTrue($negotiator->wants('compress'));
        $this->assertTrue($negotiator->prefers('compress', 'identity'));
        $this->assertTrue($negotiator->prefers('identity', '*'));
        $this->assertFalse($negotiator->prefers('potato', 'compress'));
        $this->assertEquals(0.8, $negotiator['*']->q());
        $this->assertEquals(0.9, $negotiator['identity']->q());
        $this->assertEquals('compress', $negotiator->best()->getBaseType());
        $this->assertEquals('2', $negotiator->best()->params()->level);
    }
}