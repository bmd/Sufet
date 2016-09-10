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
    /** @inheritdoc */
    public $headerName = 'accept-charset';

    /**
     * Decompose the the accept-charset header into a list of acceptable
     * charsets. If no accept-charset header is specified, or is false-y,
     * we can assume that the client is willing to accept any charset
     * the server can provide, with a preference for ISO-8859-1 if it's
     * available unless ISO-8859-1 is explicitly refused.
     *
     * Multiple acceptable charsets are separated by a comma and are not
     * required to be presented in q-order, so the parser must sort content
     * types defensively.
     *
     * @link https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.2
     *
     * @param  mixed $charsets
     * @return ContentTypeCollection
     */
    protected function parseHeader($charsets)
    {
        return new ContentTypeCollection($charsets ?: '*');
    }

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

        // If no "*" is present in an Accept-Charset field, then all character
        // sets not explicitly mentioned get a quality value of 0, except for
        // ISO-8859-1, which gets a quality value of 1 if not explicitly
        // mentioned.
        if ($a->getBaseType() === 'ISO-8859-1') {
            return 1;
        }

        if ($b->getBaseType() === 'ISO-8859-1') {
            return -1;
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
     * Return a boolean value indicating whether the client prefers one charset
     * to another.
     *
     * @param  string $type
     * @param  string $to
     * @return bool
     */
    public function prefers($type, $to)
    {
        $c = new ContentType($type);
        $t = new ContentType($to);
        if ($this->contentTypes->get($type) && $this->contentTypes->get($to)) {
            return false;
        }

        return $this->contentTypes->get($type)->q() >= $this->contentTypes->get($type)->q();
    }

    /**
     * Return a boolean value indicating whether the client is willing to
     * accept the specified charset.
     *
     * A charset will be accepted IF:
     *   1. The client will accept a charset if it's explicitly included
     *      in the header AND has a q-value greater than 0.
     *   2. ISO-8859-1 will always be considered acceptable UNLESS it is
     *      refused with a q-value of exactly 0.0
     *   3. The client is willing to accept the wildcard '*'
     *
     * @param  string $charset
     * @return bool
     */
    public function willAccept($charset)
    {
        $c = new ContentType($charset);

        if ($this->contentTypes->get($c->getBaseType()) && $this->contentTypes->get($c->getBaseType())->q() > 0.0) {
            return true;
        }

        if ($c->getBaseType() === 'ISO-8859-1' && (!$this->contentTypes->get('ISO-8859-1') || $this->contentTypes->get('ISO-8859-1')->q() > 0.0)) {
            return true;
        }

        if ($this->contentTypes->get('*') && $this->contentTypes->get('*')->q() > 0.0) {
            return true;
        }

        return false;
    }
}