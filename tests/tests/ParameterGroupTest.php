<?php

use Sufet\Entities\ParameterGroup;

/**
 * Class ParameterGroupTest
 */
class ParameterGroupTest extends PHPUnit_Framework_TestCase
{
    public function testParameterGroupConsumesString()
    {
        $p = new ParameterGroup(['charset=UTF-8', 'foo=bar', 'baz=qux']);
        $this->assertInstanceOf('Sufet\\Entities\\ParameterGroup', $p);
    }

    public function testParameterGroupContainsExpectedParameters()
    {
        $p = new ParameterGroup(['charset=UTF-8', 'foo=bar', 'baz=qux']);
        $this->assertEquals('bar', $p->foo);
        $this->assertEquals('qux', $p->baz);
        $this->assertEquals('UTF-8', $p->charset);
    }

    public function testAllParametersCanBeReturned()
    {
        $p = new ParameterGroup(['charset=UTF-8', 'foo=bar', 'baz=qux']);
        $this->assertArrayHasKey('foo', $p->all());
        $this->assertArrayHasKey('charset', $p->all());
    }

    public function testInvalidParameterAccessRaisesException()
    {

    }

    public function testDefaultFallbackWorks()
    {

    }
}