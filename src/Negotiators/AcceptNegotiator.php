<?php
namespace Sufet\Negotiators;

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