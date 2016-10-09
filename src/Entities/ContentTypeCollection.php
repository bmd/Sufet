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
class ContentTypeCollection
{

    /**
     * The collection of ContentType objects made available to the negotiator
     * class.
     *
     * @var array
     */
    protected $types = [];

    /**
     * ContentTypeCollection constructor.
     *
     * @param  string $rawString
     */
    public function __construct($rawString)
    {
        foreach (explode(',', $rawString) as $type) {
            $t = new ContentType($type);
            $this->types[] = $t;
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
     * @param string      $type
     * @param null|string $subtype (optional)
     * @param array       $parameters (optional)
     * @param bool        $first (optional)
     * @return array|null|\Sufet\Entities\ContentType
     */
    public function get($type, $subtype = null, $parameters = [], $first = true)
    {
        $acceptableTypes = [];
        /** @var ContentType $compType */
        foreach ($this->types as $compType) {
            if ($type !== $compType->getBaseType()) {
                break;
            }

            if ($subtype && $subtype !== $compType->getSubType()) {
                break;
            }

            // @TODO handle cases where we're filtering on parameters as well as types

            if ($first) {
                return $compType;
            } else {
                print_r("Appending to acceptable types");
                $acceptableTypes[] = $compType;
            }
        }

        return $first ? null : $acceptableTypes;
    }
}