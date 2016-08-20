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
use Sufet\Entities\ContentTypeCollection;

/**
 * Class AcceptCharsetNegotiator
 * @package Sufet\Negotiators
 */
class AcceptCharsetNegotiator extends AbstractNegotiator
{
    /** @var string */
    public $headerName = 'accept-charset';

    /**
     * Order charsets according to the preference. The sorting criteria
     * for charsets are simple compared to other media types. Only the
     * qvalue and wildcard criteria are used.
     *
     * @link https://www.w3.org/Protocols/rfc2616/rfc2616-sec3.html#sec14.2
     *
     * @param  \Sufet\Entities\ContentType $a
     * @param  \Sufet\Entities\ContentType $b
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

        return 0;
    }

    /**
     * Return true if the specified charset is the charset that the
     * client consideres the best.
     *
     * @param  string $type
     * @return bool
     */
    public function wants($type)
    {
        return $this->best()->getBaseType() === $type;
    }

    /**
     *
     *
     * @param  string $type
     * @param  string $to
     * @return bool
     */
    public function prefers($type, $to)
    {
        $c = new ContentType($type);
        $t = new ContentType($to);
        if (!isset($this->contentTypes[$type]) && !isset($this->contentTypes[$to])) {
            return false;
        }
        return $this->contentTypes[$type]->q() >= $this->contentTypes[$type]->q();
    }

    public function willAccept($type)
    {
        $c = new ContentType($type);
    }

    protected function parseHeader($headerContent)
    {
        // TODO: Implement parseHeader() method.
    }


}