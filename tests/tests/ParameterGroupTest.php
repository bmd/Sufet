<?php
use Sufet\Entities\Parameters;

/**
 * Class ParameterGroupTest
 */
class ParameterGroupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_instantiate_parameter_object_from_string()
    {
        $this->assertInstanceOf(Parameters::class, new Parameters('charset=UTF-8;foo=bar;baz=qux'));
    }

    /**
     * @test
     */
    public function it_should_parse_expected_parameters()
    {
        $p = new Parameters('charset=UTF-8;foo=bar;baz=qux');
        $this->assertEquals('bar', $p->get('foo'));
        $this->assertEquals('qux', $p->get('baz'));
        $this->assertEquals('utf-8', $p->get('charset'));
    }

    /**
     * @test
     */
    public function it_should_treat_parameters_as_case_insensitive()
    {
        $p = new Parameters('CHARSET=UTF-8;FOO=bar;BAZ=qux');
        $this->assertEquals('bar', $p->get('foo'));
        $this->assertEquals('qux', $p->get('baz'));
        $this->assertEquals('utf-8', $p->get('charset'));
    }

    /**
     * @test
     */
    public function it_should_retrieve_correct_q_value()
    {
        $p = new Parameters('charset=UTF-8;foo=bar;q=0.3');
        $this->assertEquals(0.3, $p->q());
    }

    /**
     * @test
     */
    public function it_should_return_q_value_1_when_no_explicit_q_is_provided()
    {
        $p = new Parameters('charset=UTF-8;foo=bar;baz=qux');
        $this->assertEquals(1.0, $p->q());
    }

    /**
     * @test
     */
    public function it_should_return_fallback_value_if_parameter_is_not_found()
    {
        $p = new Parameters('charset=UTF-8;foo=bar;baz=qux');
        $this->assertNull($p->get('x'));
        $this->assertEquals('fallback', $p->get('x', $default = 'fallback'));
    }

    /**
     * @test
     */
    public function it_should_allow_non_letter_values_in_parameter_names()
    {
        $p = new Parameters('charset=UTF-8;foo-bar=bar;baz=qux');
        $this->assertEquals('bar', $p->get('foo-bar'));
    }
}