<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Entities
 * @author     Brendan Maione-Downing <author@example.com>
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

    /** @var array */
    public $types = [];

    /**
     * ContentTypeCollection constructor.
     *
     * @param  string $rawString
     */
    public function __construct($rawString)
    {
        foreach (explode(',', $rawString) as $type) {
            $this->types[] = new ContentType($type);
        }
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

    public function all()
    {
        return array_values($this->types);
    }

}