<?php
namespace Sufet\Negotiators;

use Sufet\Entities\ContentType;
use Sufet\Entities\NegotiableCollection;

/**
 * Class AcceptNegotiator
 * @package Sufet\Negotiators
 */
class AcceptNegotiator extends AbstractNegotiator
{
    /**
     * @param string $types
     * @return NegotiableCollection
     */
    protected function parseHeader($types)
    {
        return new NegotiableCollection($types ?: '*');
    }

    /**
     * @param string $type
     * @return bool
     */
    public function wants($type)
    {
        return $this->best()->getType() === $type;
    }

    /**
     * @param string $type
     * @param string $to
     * @return bool
     */
    public function prefers($type, $to)
    {
        return $this->contentTypes[$type]->q >= $this->contentTypes[$type]->q;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function willAccept($type)
    {
        return true;
    }

    /**
     * @param ContentType $a
     * @param ContentType $b
     * @return int
     */
    protected function sortTypes(ContentType $a, ContentType $b)
    {
        if ($a->q() > $b->q()) {
            return 1;
        }

        if ($b->q() > $a->q()) {
            return -1;
        }

        if ($a->isWildCardType()) {
            return -1;
        }

        if ($b->isWildCardType()) {
            return 1;
        }

        if ($a->isWildCardSubtype()) {
            return -1;
        }

        if ($b->isWildCardSubtype()) {
            return 1;
        }

        return 0;
    }
}