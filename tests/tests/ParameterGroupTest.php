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

use Sufet\Entities\ParameterGroup;

/**
 * Class ParameterGroupTest
 */
class ParameterGroupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param  array $params
     * @return \Sufet\Entities\ParameterGroup
     */
    protected function getParameterGroup(array $params)
    {
        return new ParameterGroup($params);
    }

    /**
     * @group Parameters
     */
    public function testParameterGroupConsumesString()
    {
        $this->assertInstanceOf('Sufet\\Entities\\ParameterGroup', $this->getParameterGroup(['charset=UTF-8', 'foo=bar', 'baz=qux']));
    }

    /**
     * @group Parameters
     */
    public function testParameterGroupContainsExpectedParameters()
    {
        $p = $this->getParameterGroup(['charset=UTF-8', 'foo=bar', 'baz=qux']);
        $this->assertEquals('bar', $p->foo);
        $this->assertEquals('qux', $p->baz);
        $this->assertEquals('utf-8', $p->charset);
    }

    /**
     * @group Parameters
     */
    public function testParameterHandlingIsCaseInsensitive()
    {
        $p = $this->getParameterGroup(['CHARSET=UTF-8', 'FOO=bar', 'BAZ=qux']);
        $this->assertEquals('bar', $p->foo);
        $this->assertEquals('qux', $p->baz);
        $this->assertEquals('utf-8', $p->charset);
    }

    /**
     * @group Parameters
     */
    public function testAllParametersCanBeReturnedByMagicMethods()
    {
        $p = $this->getParameterGroup(['charset=UTF-8', 'foo=bar', 'baz=qux']);
        $this->assertArrayHasKey('foo', $p->all());
        $this->assertArrayHasKey('charset', $p->all());
        $this->assertArrayHasKey('baz', $p->all());
    }

    /**
     * @group Parameters
     */
    public function testAllParametersCanBeReturnedByArrayAccess()
    {
        $p = $this->getParameterGroup(['charset=UTF-8', 'foo=bar', 'baz=qux']);
        $this->assertEquals('bar', $p['foo']);
        $this->assertEquals('utf-8', $p['charset']);
        $this->assertEquals('qux', $p['baz']);
    }

    /**
     * @group Parameters
     */
    public function testQValueIsAccurate()
    {
        $p = $this->getParameterGroup(['charset=UTF-8', 'foo=bar', 'q=0.3']);
        $this->assertEquals(0.3, $p->q());
    }

    /**
     * @group Parameters
     */
    public function testQValueAlwaysAvailable()
    {
        $p = $this->getParameterGroup(['charset=UTF-8', 'foo=bar', 'baz=qux']);
        $this->assertEquals(1.0, $p->q());
    }

    /**
     * @group Parameters
     */
    public function testDefaultFallbackWorks()
    {
        $p = $this->getParameterGroup(['charset=UTF-8', 'foo=bar', 'baz=qux']);
        $this->assertNull($p->param('x'));
        $this->assertEquals('fallback', $p->param('x', $default='fallback'));
    }

    /**
     * @group Parameters
     */
    public function testValuesWithNonVariableCharacters()
    {
        $p = $this->getParameterGroup(['charset=UTF-8', 'foo-bar=bar', 'baz=qux']);
        $this->assertEquals('bar', $p['foo-bar']);
    }
}