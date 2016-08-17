<?php
namespace Sufet\Negotiators;

/**
 * Class Media
 * @package Sufet\Negotiators
 */
class Media extends AbstractNegotiator
{
    /**
     * Media constructor.
     */
    public function __construct($mediaType)
    {

    }

    public function wants($type)
    {
        return array_flip($this->mediaTypes)[0]->type === $type;
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

}