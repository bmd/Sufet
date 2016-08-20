<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Entities
 * @author     Brendan Maione-Downing <b.maionedowning@gmail.com>
 * @copyright  2016
 * @license    MIT
 * @link       https://github.com/bmd/Sufet
 */

namespace Sufet\Entities;

/**
 * Class AccessibleEntity
 * @package Sufet\Entities
 */
abstract class AccessibleEntity implements \ArrayAccess
{
    /**
     * Data container for implementing magic get/set methods
     * as well as the array access methods on Sufet objects.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Magic get method for Sufet entities.
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * Magic set method for Sufet entities.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Array offset method.
     *
     * @param  mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * Offset get method.
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * Offset set method.
     *
     * @param  mixed $offset
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * Offset unset method.
     *
     * @param  mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}