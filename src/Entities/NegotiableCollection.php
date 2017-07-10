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
class NegotiableCollection
{
    /**
     * The collection of ContentType objects made available to the negotiator
     * class.
     *
     * @var ContentType[]
     */
    protected $types = [];

    /**
     * ContentTypeCollection constructor.
     *
     * @param  string $rawString
     */
    public function __construct(string $rawString)
    {
        $this->types = array_map(function (string $t) {
            return new ContentType($t);
        }, explode(',', $rawString));
    }

    /**
     * @return ContentType[]
     */
    public function all()
    {
        return $this->types;
    }

    /**
     * @param string $type
     * @param null|string $subtype (optional)
     * @param array $parameters (optional)
     * @param bool $first (optional)
     * @return array|null|\Sufet\Entities\ContentType
     */
    public function find(string $type, ?string $subtype = null, array $parameters = [], bool $first = true)
    {
        $acceptableTypes = [];

        /** @var ContentType $compType */
        foreach ($this->types as $compType) {

            if ($type !== $compType->getBaseType()) {
                continue;
            }

            if ($subtype && $subtype !== $compType->getSubType()) {
                continue;
            }

            // @TODO handle cases where we're filtering on parameters as well as types

            if ($first) {
                return $compType;
            } else {
                $acceptableTypes[] = $compType;
            }
        }

        return $first ? null : $acceptableTypes;
    }
}