<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Negotiators
 * @author     Brendan Maione-Downing <b.maionedowning@gmail.com>
 * @copyright  2016
 * @license    MIT
 * @link       https://github.com/bmd/Sufet
 */

namespace Sufet\Negotiators;

use Sufet\Entities\ContentType;

/**
 * Class AcceptNegotiator
 * @package Sufet\Negotiators
 */
class AcceptNegotiator extends AbstractNegotiator
{
    /**
     * AcceptNegotiator constructor.
     */
    public function __construct($mediaType)
    {

    }

    protected function parseHeader($headerContent)
    {
        // TODO: Implement parseHeader() method.
    }


    public function wants($type)
    {
        return $this->best()->getType() === $type;
    }

    public function prefers($type, $to)
    {
        return $this->mediaTypes[$type]->q >= $this->mediaTypes[$type]->q;
    }

    public function willAccept($type)
    {
        return true;
    }

    public function hasType($type)
    {

    }

    public function best()
    {
        return $this->mediaTypes[0];
    }

    protected function sortTypes(ContentType $a, ContentType $b)
    {
        // TODO: Implement sortTypes() method.
    }


}