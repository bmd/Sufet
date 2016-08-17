<?php
namespace Sufet\Negotiators;

/**
 * Class AbstractNegotiator
 * @package Sufet\Negotiators
 */
abstract class AbstractNegotiator
{
    protected $mediaTypes;

    abstract public function wants($type);

    abstract public function prefers($type, $to);

    abstract public function willAccept($type);

    abstract public function best();

}