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

use Sufet\Negotiators\AcceptNegotiator;

class AcceptNegotiatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function emptyHeaderDataProvider()
    {
        return [
            [null],
            ['']
        ];
    }

    /**
     *
     * @test
     * @dataProvider emptyHeaderDataProvider
     *
     * @param mixed $header
     */
    public function it_should_treat_empty_header_as_wildcard($header)
    {
        $this->markTestSkipped('TODO');

        $negotiator = new AcceptNegotiator($header);

        // should be a wildcard type
        print_r($negotiator->best()->getType());
        $this->assertTrue($negotiator->best()->isWildCardType());
        $this->assertTrue($negotiator->best()->isWildCardSubtype());

        // should accept anything
        $this->assertTrue($negotiator->willAccept('application/json;q=1.0'));
        $this->assertTrue($negotiator->willAccept('x-random-bullshit-type'));
    }

    /**
     * @test
     */
    public function it_should_accept_any_as_wildcard_type()
    {
        $this->markTestSkipped('TODO');

        $wildCardMediaTypes = ['*', '*/*', '*/*;q=0.7;foo=bar'];

        foreach ($wildCardMediaTypes as $case) {
            $m = $this->getNegotiator($case);

            // should be a wildcard type
            $this->assertTrue($m->best()->isWildCardType());
            $this->assertTrue($m->best()->isWildCardSubtype());

            // should accept anything
            $this->assertTrue($m->willAccept('application/json;q=1.0'));
            $this->assertTrue($m->willAccept('x-random-bullshit-type'));
        }
    }

    /**
     * @test
     */
    public function it_should_negotiate_with_a_single_media_type()
    {
        $this->markTestSkipped('TODO');

        $m = $this->getNegotiator("application/json;q=0.5;foo=bar");

        // it's not a wildcard
        $this->assertFalse($m->best()->isWildCardType());
        $this->assertFalse($m->best()->isWildCardSubtype());

        // it's q should be exactly 0.5
        $this->assertEquals(0.5, $m->best()->q());

        // it should carry along its parameters
        $this->assertEquals('bar', $m->best()->params()->foo);

        // it should accept application json and the defined variant
        $this->assertTrue($m->willAccept('application/json'));
        $this->assertTrue($m->willAccept('application/json;foo=bar'));

        // it should reject other variants and media types
        $this->assertFalse($m->willAccept('application/json;baz=qux'));
        $this->assertFalse($m->willAccept('application/xml+xhtml'));
        $this->assertFalse($m->willAccept('*'));
    }
}
