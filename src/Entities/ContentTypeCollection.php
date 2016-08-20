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
 * Class ContentTypeCollection
 * @package Sufet\Entities
 */
class ContentTypeCollection implements \ArrayAccess
{

    /**
     * The collection of ContentType objects made available to the negotiator
     * class.
     *
     * @var array
     */
    public $types = [];

    /**
     * ContentTypeCollection constructor.
     *
     * @param  string $rawString
     */
    public function __construct($rawString)
    {
        foreach (explode(',', $rawString) as $type) {
            $t = new ContentType($type);
            $this->types[$t->getBaseType()] = $t;
        }
    }

    /**
     * Return the names of all content types that are considered acceptable by
     * the client.
     *
     * @return array
     */
    public function all()
    {
        return array_values($this->types);
    }

    /**
     * @param  mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->types);
    }

    /**
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->types[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof ContentType) {
            throw new \InvalidArgumentException("All entities must be an instance of \\Sufet\\Entities\\ContentType");
        }
        $this->types[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->types[$offset]);
    }
}