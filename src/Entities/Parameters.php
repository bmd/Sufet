<?php
namespace Sufet\Entities;

/**
 * Class Parameter
 * @package Sufet\Entities
 */
class Parameters implements \ArrayAccess
{

    /** @var array */
    private $parameters = [];

    /**
     * Parameters constructor.
     *
     * @param $paramString
     */
    public function __construct($paramString)
    {
        $this->parameters = $this->parseParameters($paramString);
    }

    /**
     * @param $params
     */
    protected function parseParameters($params)
    {

    }

    /**
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->parameters[$name];
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->parameters);
    }

    public function offsetGet($offset)
    {
        return $this->parameters[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->parameters[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }


}