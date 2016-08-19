<?php
/**
 * Sufet is a content-negotiation library and PSR-7 compliant middleware.
 *
 * @category   Sufet
 * @package    Negotiators
 * @author     Brendan Maione-Downing <author@example.com>
 * @copyright  2016
 * @license    MIT
 * @link       https://github.com/bmd/Sufet
 */

namespace Sufet\Negotiators;

use Sufet\Entities\ContentType;
use Sufet\Entities\ContentTypeCollection;

/**
 * Class AcceptEncodingNegotiator
 * @package Sufet\Negotiators
 */
class AcceptEncodingNegotiator extends AbstractNegotiator
{
    /** @var string */
    public $headerName = 'accept-encoding';

    /**
     * Decompose the accept-encoding header into a list of acceptable encodings.
     * If no accept-encoding header is specified, or it's false-y (i.e. ''),
     * then we may assume that the client is willing to accept any content
     * encoding and should return the 'identity' encoding unless it is explicitly
     * refused. Otherwise any encoding will do.
     *
     * Multiple acceptable content types are separated by a comma, and are not
     * required to be presented in q-order, so the parser must sort content
     * types defensively.
     *
     * Content-coding types do not have a subtype or vendor/x-tree specification
     * so no helper functions are available for dealing with non-standard content
     * types.
     *
     * @link https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.3
     *
     * @param mixed $encodings
     */
    protected function parseHeader($encodings)
    {
        $encodings = $encodings ?: '*';

        $this->contentTypes = new ContentTypeCollection($encodings);
        foreach (preg_split('/,/', $encodings) as $encoding) {
            $this->contentTypes[] = new ContentType($encoding);
        }
    }

    /**
     * Check the sorting array of
     *
     * @param  ContentType $a
     * @param  ContentType $b
     * @return int
     */
    protected function sortTypes(ContentType $a, ContentType $b)
    {

    }

    /**
     * Return true if the specified content type is the type that
     * the client considers the best (either the only type
     * specified OR the type with the highest quality parameter).
     *
     * In the case where two encodings are equally preferable, the
     * tie-break logic is as follows:
     *   1) A more specific should be preferred over a more general
     *      content-coding directive.
     *      a) Anything is preferred over a wildcard ('*').
     *      b) Anything _except_ a wildcard is preferred over the
     *         'identity' type.
     *   2) If two directives are equally specific, the preference
     *      order will be from left -> right in the original header.
     *
     *      E.g. for the header 'compress;q=0.5,gzip;q=0.5':
     *          $this->wants('compress') // true
     *          $this->wants('gzip')     // false
     *
     *      ... but for the header 'identity:q=0.5,gzip=0.5':
     *          $this->wants('gzip')     // true
     *          $this->wants('identity') // false
     *
     * @param  string $type
     * @return bool
     */
    public function wants($type)
    {
        return $this->contentTypes->best()->baseType === $candidate;
    }

    /**
     * Return a boolean value indicating whether the client prefers
     * one specified encoding to another.
     *
     * @param  string $encoding
     * @param  string $to
     * @return bool
     */
    public function prefers($encoding, $to)
    {
        // 1. $type will be accepted
        if (isset($this->contentTypes[$encoding]) and $this->contentTypes[$encoding]->q() > 0) {
            if (!isset($this->contentTypes[$to]) || $this->contentTypes[$to]->q() < $this->contentTypes[$encoding]->q()) {
                return true;
            } elseif ($this->contentTypes[$to]->q() >= $this->contentTypes[$encoding]->q()) {
                return false;
            }
        }

        // 2. $type will NOT be accepted
    }

    /**
     * Return a boolean value indicating whether the client is willing
     * to accept the specified encoding.
     *
     * The criteria under which a client WILL accept an ecoding are:
     *   1) that encoding is explicitly included in the list of acceptable
     *      encoding types in the `accept-encoding` header.
     *   2) the `accept-encoding` header includes the wildcard '*' AND
     *      the quality parameter for '*' is not 0 (i.e. we can't
     *      consider '*;q=0' to mean that a client is willing to accept
     *      any encoding type because '*;q=0' is designed to allow the
     *      client to blacklist a response using any encoding other than
     *      its expected types.
     *
     * The 'identity' content-coding is a special case. UNLESS the accept
     *
     *
     * @param  string $type
     * @return bool
     */
    public function willAccept($type)
    {
        if (in_array($type, $this->contentTypes->accepts())) {
            return true;
        }

        if (isset($this->contentTypes['*']) && $this->contentTypes['*']->params()->q() != 0.0) {
            return true;
        }

        return false;
    }


}