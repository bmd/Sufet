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

use Sufet\Negotiators\AcceptLanguageNegotiator;

class AcceptLanguageNegotiatorTest extends PHPUnit_Framework_TestCase
{

    protected function getNegotiator($language)
    {
        return new AcceptLanguageNegotiator($language);
    }

    public function testInstantiatesNegotiator()
    {
        $this->assertTrue(true);
    }

}
