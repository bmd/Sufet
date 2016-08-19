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
 * Class AcceptCharsetNegotiator
 * @package Sufet\Negotiators
 */
class AcceptCharsetNegotiator extends AbstractNegotiator
{
    protected function sortTypes(ContentType $a, ContentType $b)
    {
        // TODO: Implement sortTypes() method.
    }

    /**
     * AcceptCharsetNegotiator constructor.
     *
     * @param string $rawHeader
     */
    public function __construct($rawHeader)
    {
        $this->contentTypes = new ContentTypeCollection($rawHeader);
    }

    /**
     * @inheritdoc
     */
    public function wants($type)
    {
        foreach ($this->contentTypes->getBestType() as $candidate) {
            if ($candidate->baseName === $type) {
                return true;
            }
        }

        return false;
    }

    /**
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

    public function best()
    {
        // TODO: Implement best() method.
    }

    protected function parseHeader($headerContent)
    {
        // TODO: Implement parseHeader() method.
    }


}