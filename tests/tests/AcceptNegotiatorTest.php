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

    protected function getNegotiator($media)
    {
        return new AcceptNegotiator($media);
    }

    /**
     * @group Accept
     */
    public function testHandlesEmptyParameter()
    {
        $emptyParameters = ['', null];

        foreach ($emptyParameters as $case) {
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
     * @group Accept
     */
    public function handlesWildCardType()
    {
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
     * @group Accept
     */
    public function handlesSingleMediaType()
    {
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
